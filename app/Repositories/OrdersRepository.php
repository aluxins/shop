<?php

namespace App\Repositories;

use App\Models\StoreOrders;
use App\Repositories\Interfaces\OrdersRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrdersRepository implements OrdersRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getOrdersByUserId($userId, $parameters): mixed
    {
        return StoreOrders::where('user', $userId)
            ->where(function($query) use ($parameters){
                if(!empty($parameters['dateStart']))$query->where('created_at', '>=', $parameters['dateStart'] . ' 00:00:00');
                if(!empty($parameters['dateEnd']))$query->where('created_at', '<=', $parameters['dateEnd'] . ' 23:59:59');
                if(isset($parameters['status']))$query->where('status', '=', $parameters['status']);
            })
            ->leftJoin('store_orders_products', 'store_orders.id', '=', 'store_orders_products.order')
            ->select('store_orders.id','store_orders.status','store_orders.created_at','store_orders.updated_at',
                DB::raw('SUM(store_orders_products.quantity * store_orders_products.price) as price')
            )
            ->groupBy('id', 'status', 'created_at', 'updated_at')
            ->orderByDesc('store_orders.id');
    }

    /**
     * @inheritDoc
     */
    public function getOrderById($userId, $orderId): mixed
    {
        return StoreOrders::where('store_orders.id', $orderId)->where('store_orders.user', '=', $userId)
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
            ->first();
    }
}
