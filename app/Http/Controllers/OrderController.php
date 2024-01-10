<?php

namespace App\Http\Controllers;

use App\Models\StoreOrders;
use App\Models\StoreProduct;
use App\Models\StoreProfiles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request, $id = 0): \Illuminate\Contracts\View\View
    {
        // Валидация параметров фильра.
        $validated = Validator::make($request->isMethod('get') ? $_GET : $_POST, [
            'date-start'    => 'nullable|date',
            'date-end'    => 'nullable|date',
            'status' => 'nullable|numeric',
        ])->validate();


        $orders = $id > 0 ?
            // Заказ # $id
            StoreOrders::where('store_orders.id', $id)->where('store_orders.user', '=', $request->user()->id)
                ->leftJoin('store_orders_products', 'store_orders.id', '=', 'store_orders_products.order')
                ->leftJoin('store_products', 'store_orders_products.product', '=', 'store_products.id')
                ->select('store_orders.id','store_orders.status','store_orders.created_at','store_orders.updated_at',
                    DB::raw('
                        JSON_OBJECTAGG(store_orders_products.id, store_orders_products.product) as product,
                        JSON_OBJECTAGG(store_orders_products.id, store_products.name) as name,
                        JSON_OBJECTAGG(store_orders_products.id, store_orders_products.quantity) as quantity,
                        JSON_OBJECTAGG(store_orders_products.id, store_orders_products.price) as price,
                        JSON_OBJECTAGG(store_orders_products.id, (
                            SELECT `name`
                            FROM `store_images`
                            WHERE `store_images`.`product` = `store_products`.`id`
                            ORDER BY `sort`, `id` ASC
                            limit 1
                        ))  AS `image`
                    '),
                )
                ->groupBy('id', 'status', 'created_at', 'updated_at')
                ->first()->toArray()
            :
            // Список заказов пользователя.
            StoreOrders::where('user', $request->user()->id)
                ->where(function($query) use ($validated){
                    if(!empty($validated['date-start']))$query->where('created_at', '>=', $validated['date-start']);
                    if(!empty($validated['date-end']))$query->where('created_at', '<=', $validated['date-end']);
                    if(isset($validated['status']))$query->where('status', '=', $validated['status']);
                })
                ->leftJoin('store_orders_products', 'store_orders.id', '=', 'store_orders_products.order')
                ->select('store_orders.id','store_orders.status','store_orders.created_at','store_orders.updated_at',
                    DB::raw('SUM(store_orders_products.quantity * store_orders_products.price) as price')
                )
                ->groupBy('id', 'status', 'created_at', 'updated_at')
                ->orderByDesc('store_orders.id')->paginate(10);

        if(!$id > 0)$orders->appends([
            'date-start' => $validated['date-start'] ?? '',
            'date-end' => $validated['date-end'] ?? '',
            'status' => $validated['status'] ?? '',
        ]);

        return ($id > 0 and $orders) ?
            view('order.id',['id' => $id, 'order' => $orders])
            :
            view('order.list',['orders' => $orders, 'filter' => $validated]);

    }
    public function create(Request $request): \Illuminate\Contracts\View\View|RedirectResponse
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

            // Перенаправляем на созданный заказ. Удаляем cookie 'cart'.
            $request->session()->flash('message', 'order-store');
            return redirect()->route('order.index', ['id' => $order->id])->withoutCookie('cart');
        }
        else {
            $request->session()->flash('message', 'order-error');
            return redirect()->route('order.create');
        }
    }
}
