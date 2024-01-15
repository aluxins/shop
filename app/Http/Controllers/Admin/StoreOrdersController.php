<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StoreOrdersController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'dateStart'    => 'nullable|date',
            'dateEnd'    => 'nullable|date',
            'status' => 'nullable|numeric',
        ]);

        $orders = StoreOrders::where('status', $validated['status'] ?? 0)
            ->where(function($query) use ($validated){
                if(!empty($validated['dateStart']))$query->where('created_at', '>=', $validated['dateStart'] . ' 00:00:00');
                if(!empty($validated['dateEnd']))$query->where('created_at', '<=', $validated['dateEnd'] . ' 23:59:59');
            })
            ->leftJoin('users', 'store_orders.user', '=', 'users.id')
            ->leftJoin('store_orders_products', 'store_orders.id', '=', 'store_orders_products.order')
            ->select('store_orders.id','store_orders.status','store_orders.created_at','store_orders.updated_at',
                'users.id as user_id', 'users.name as login',
                DB::raw('SUM(store_orders_products.quantity * store_orders_products.price) as price')
            )
            ->groupBy('id', 'status', 'created_at', 'updated_at', 'user_id', 'login')
            ->orderByDesc('store_orders.id')->paginate(10);

        // Добавляем параметры в url пагинатора.
        $orders->appends([
            'dateStart' => $validated['dateStart'] ?? '',
            'dateEnd' => $validated['dateEnd'] ?? '',
            'status' => $validated['status'] ?? '',
        ]);

        return view('admin.orders', ['filter' => $validated, 'orders' => $orders]);
    }

    public function order($id): View
    {
        $order = StoreOrders::where('store_orders.id', (int) $id)
                ->leftJoin('users', 'store_orders.user', '=', 'users.id')
                ->leftJoin('store_orders_products', 'store_orders.id', '=', 'store_orders_products.order')
                ->leftJoin('store_products', 'store_orders_products.product', '=', 'store_products.id')
                ->select('store_orders.id','store_orders.status','store_orders.created_at','store_orders.updated_at',
                    'users.id as user_id', 'users.name as login',
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
                ->groupBy('id', 'status', 'created_at', 'updated_at', 'user_id', 'login')
                ->first()->toArray();

        return view('admin.orders-id', ['id' => $id, 'order' => $order]);
    }
}
