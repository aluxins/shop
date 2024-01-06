<?php

namespace App\Http\Controllers;

use App\Models\StoreOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        //return view('order');
        $cart = json_decode($request->cookie('cart'), true);

        if(!empty($cart)){
            // Преобразование входящего массива.
            $products = [];
            foreach($cart as $key => $val){
                $products[] = [
                    'product' => $key,
                    'quantity' => $val,
                ];
            }

            // Валидация входных данных.
            $validator = Validator::make($products, [
                '*.product' => 'required|numeric',
                '*.quantity' => 'required|numeric|min:0|max:1000',
            ]);

            if ($validator->valid()) {

                $order = StoreOrders::create([
                    'user' => $request->user()->id,
                    'status' => 0,
                ]);
                dd($request->user()->id, $order->id);
            }
        }
        return "redirect error";
        //return redirect()->route('order.index');
    }
}
