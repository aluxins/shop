<?php

namespace App\Http\Controllers;

use App\Models\StoreOrders;
use App\Models\StoreProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request, $id = 0)
    {
        return 'Создан заказ'. $id;
    }
    public function create(Request $request)
    {
        return view('order');
    }

    /**
     * Создание нового заказа.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): redirectResponse
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
                '*.product' => 'required|numeric',
                '*.quantity' => 'required|numeric|min:0|max:1000',
            ]);

            if ($validator->valid()) {

                // Создаем ордер заказа.
                $order = StoreOrders::create([
                    'user' => $request->user()->id,
                    'status' => 0,
                ]);

                // Товары заказа.
                $products = new StoreProduct;
                $products = $products->whereIn('id', array_keys($validator->valid()))
                    ->select('id', 'name', 'price', 'available')->get();

                // Определяем quantity, равное количеству каждой позиции в заказе.
                // Если количество превышает products.available, то quantity = products.available.
                // Вычитаем количество quantity со склада products.available.
                // Формируем массив товаров для вставки в store_orders_products.
                $insert = [];
                foreach($products as $product){
                     $quantity = $validator->valid()[$product->id]['quantity'] <= $product->available ?
                        $validator->valid()[$product->id]['quantity'] : $product->available;
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
        }
        $request->session()->flash('message', 'order-error');
        return redirect()->route('order.create');
    }
}
