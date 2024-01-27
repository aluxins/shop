<?php

namespace App\Repositories;

use App\Models\StoreProduct;
use App\Repositories\Interfaces\ProductsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ProductsRepositoryInterface {

    public function getProductsBySections(array $sectionsId, array $brandsId, string $orderBy): mixed
    {
        return StoreProduct::where(function ($query) use ($sectionsId, $brandsId) {
            $query->where('visible', 1);
            $query->whereIn('section', $sectionsId);
            if(count($brandsId) > 0)$query->whereIn('brand', $brandsId);
        })
            ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
            ->select('store_products.id','store_products.name','article', 'price', 'old_price', 'available',
                DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
            ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available')
            ->when(!empty($orderBy), function ($query) use ($orderBy) {
                switch ($orderBy) {
                    case 'priceMin':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'priceMax':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'new':
                        $query->orderBy('id', 'desc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            });
    }

    public function getProductById(int $productId): mixed
    {
        return StoreProduct::where(function ($query) use ($productId) {
            $query->where('store_products.id', $productId);
            $query->where('visible', 1);
        })
            ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
            ->leftJoin('store_brands', 'store_products.brand', '=', 'store_brands.id')
            ->select('store_products.id','store_products.name','article', 'section',
                'description', 'price', 'old_price', 'available', 'store_brands.name as brand',
                DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
            ->groupBy('store_products.id', 'store_products.name', 'article', 'section', 'description',
                'price', 'old_price', 'available', 'store_brands.name')
            ->first();
    }

    public function searchProducts(string $searchQuery, string $orderBy): mixed
    {
        return StoreProduct::where(function ($query) use ($searchQuery) {
            $query->whereRaw('visible = 1');
            $query->where(function ($query) use ($searchQuery) {
                $query->whereRaw('article = ?');
                $query->orWhereRaw('MATCH(store_products.name) AGAINST(?)
                                  + MATCH(store_products.description) AGAINST(?)',
                    [$searchQuery, $searchQuery, $searchQuery]);
            });
        })
            ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
            ->selectRaw('store_products.id, store_products.name, article, price, old_price, available,
                    JSON_OBJECTAGG(store_images.name, store_images.sort) as images,
                    IF(article = ?, 1, 0) * 3
                    + MATCH(store_products.name) AGAINST(?) * 2
                    + MATCH(store_products.description) AGAINST(?) * 1
                    as relevant', [$searchQuery, $searchQuery, $searchQuery])
            ->selectRaw("IF(available > 0, 1, 0) AS available_sort")
            ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available', 'relevant')
            ->orderByDesc('available_sort')->orderByDesc('relevant')
            ->when(!empty($orderBy), function ($query) use ($orderBy) {
                switch ($orderBy) {
                    case 'priceMin':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'priceMax':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'new':
                        $query->orderBy('id', 'desc');
                        break;
                    default:
                        $query->orderBy('id', 'desc');
                }
            });
    }

    public function cartProducts(array $productsId): array
    {
        return StoreProduct::whereIn('store_products.id', $productsId)
            ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
            ->select('store_products.id','store_products.name','article',
                'price', 'old_price', 'available',
                DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
            ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available')
            ->get()->toArray();
    }
/*
    public function deleteProduct(int $productId)
    {
        // TODO: Implement deleteProduct() method.
    }

    public function createProduct(array $data)
    {
        // TODO: Implement createProduct() method.
    }

    public function updateProduct($productId, array $newData)
    {
        // TODO: Implement updateProduct() method.
    }
*/
}
