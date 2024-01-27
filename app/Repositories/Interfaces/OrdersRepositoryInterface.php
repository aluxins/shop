<?php

namespace App\Repositories\Interfaces;

interface OrdersRepositoryInterface
{
    /**
     * Получить экземпляр модели заказов пользователя.
     * @param int $userId
     * @param array $parameters
     * @return mixed
     */
    public function getOrdersByUserId(int $userId, array $parameters): mixed;

    /**
     * Получить экземпляр модели заказа по Id.
     * @param int $userId
     * @param int $orderId
     * @return mixed
     */
    public function getOrderById(int $userId, int $orderId): mixed;
}
