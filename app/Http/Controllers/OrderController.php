<?php

namespace App\Http\Controllers;

use App\Models\StoreOrders;
use App\Models\StoreProduct;
use App\Models\StoreProfiles;
use App\Notifications\OrderCreate;
use App\Notifications\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\OrdersRepositoryInterface;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function index(Request $request, OrdersRepositoryInterface $ordersRepository): View
    {

        // Валидация параметров фильра.
        $validated = Validator::make($request->all(), [
            'dateStart'    => 'nullable|date',
            'dateEnd'    => 'nullable|date',
            'status' => 'nullable|numeric',
        ])->valid();

        $orders = $ordersRepository->getOrdersByUserId($request->user()->id, $validated)->paginate(10);

        if(is_null($orders))abort(404);

        // Добавляем параметры в url пагинатора.
        $orders->appends([
            'dateStart' => $validated['dateStart'] ?? '',
            'dateEnd' => $validated['dateEnd'] ?? '',
            'status' => $validated['status'] ?? '',
        ]);

        return view('order.list',['orders' => $orders, 'filter' => $validated]);

    }

    public function order(Request $request, OrdersRepositoryInterface $ordersRepository, $id): View
    {
        $order = $ordersRepository->getOrderById($request->user()->id, $id);

        if(is_null($order))abort(404);

        return view('order.id',['id' => $id, 'order' => $order->toArray()]);
    }
    public function create(Request $request): View|RedirectResponse
    {
        $validator = self::cookie($request);

        if (count($validator) > 0) {
            // Товары заказа.
            $products = new StoreProduct;
            $products = $products->whereIn('id', array_keys($validator))
                ->select('id', 'name', 'price', 'old_price', 'available')->get();


            $order = ['total' => 0, 'sale' => 0, 'full' => 0];
            foreach($products as $product){
                // Если количество товара в заказе превышает складские остатки, то уменьшаем до соответствующего количества.
                $quantity = min($validator[$product->id]['quantity'], $product->available);

                // Определяем сумму заказа и скидку.
                $order['total'] += $product->price * $quantity;
                $order['sale'] += ($product->old_price > $product->price) ? ($product->old_price - $product->price) * $quantity : 0;
                $order['full'] += max($product->price, $product->old_price) * $quantity;
             }

            return view('order.create',[
                'user' => $request->user(),
                'order' => $order,
                'information' => StoreProfiles::where('user', $request->user()->id)->first()
            ]);
        }
        else return redirect()->back();
    }

    /**
     * Создание нового заказа.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): redirectResponse
    {
        $validator = self::cookie($request);

        if (count($validator) > 0) {

            // Создаем ордер заказа.
            $order = StoreOrders::create([
                'user' => $request->user()->id,
                'status' => 0,
            ]);

            // Товары заказа.
            $products = new StoreProduct;
            $products = $products->whereIn('id', array_keys($validator))
                ->select('id', 'name', 'price', 'available')->get();

            // Определяем quantity, равное количеству каждой позиции в заказе.
            // Если количество превышает products.available, то quantity = products.available.
            // Вычитаем количество quantity со склада products.available.
            // Формируем массив товаров для вставки в store_orders_products.
            $insert = [];
            foreach($products as $product){
                $quantity = min($validator[$product->id]['quantity'], $product->available);
                $product->available -= $quantity;
                $product->save();
                $product->quantity = $quantity;
                $insert[] = [
                    'order' => $order->id,
                    'product' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            // Вставляем позиции заказа.
            DB::table('store_orders_products')->insert($insert);

            // Отправка email пользователю.
            $request->user()->notify(new OrderCreate($order->id));

            // Перенаправляем на созданный заказ. Удаляем cookie 'cart'.
            $request->session()->flash('message', 'order-store');
            return redirect()->route('order.index', ['id' => $order->id])->withoutCookie('cart');
        }
        else {
            $request->session()->flash('message', 'order-error');
            return redirect()->route('order.create');
        }
    }

    /**
     * Получение cookie 'cart' и валидация.
     * @param Request $request
     * @return array [ key => ['product' => id, 'quantity' => quantity], ...]
     *
     */
    private function cookie(Request $request): array
    {
        $cart = json_decode($request->cookie('cart'), true);

        if(!empty($cart)){
            // Преобразование входящего массива.
            $products = [];
            foreach($cart as $key => $val){
                $products[$key] = [
                    'product' => (int) $key,
                    'quantity' => (int) $val,
                ];
            }

            // Валидация входных данных.
            $validator = Validator::make($products, [
                '*.product' => 'required|numeric|min:1',
                '*.quantity' => 'required|numeric|min:0|max:1000',
            ]);

            if ($validator->valid()) {
                return $validator->valid();
            }
        }
        return [];
    }
}
