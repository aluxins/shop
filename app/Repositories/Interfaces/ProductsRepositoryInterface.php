<?php

namespace App\Repositories\Interfaces;

interface ProductsRepositoryInterface
{
    /**
     * Получить экземпляр модели товаров, принадлежащих Id sections и Id brands и отсортированных по $orderBy.
     * @param array $sectionsId
     * @param array $brandsId
     * @param string $orderBy
     * @return mixed
     */
    public function getProductsBySections(array $sectionsId, array $brandsId, string $orderBy): mixed;

    /**
     * Получить экземпляр модели товара по Id.
     * @param int $productId
     * @return mixed
     */
    public function getProductById(int $productId): mixed;

    /**
     * Поиск товаров по запросу $searchQuery, отсортированных по $orderBy.
     * @param string $searchQuery
     * @param string $orderBy
     * @return mixed
     */
    public function searchProducts(string $searchQuery, string $orderBy): mixed;

    /**
     * Массив товаров в корзине.
     * @param array $productsId
     * @return mixed
     */
    public function cartProducts(array $productsId): array;
/*
    public function deleteProduct(int $productId);
    public function createProduct(array $data);
    public function updateProduct($productId, array $newData);
*/
}
