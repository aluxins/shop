<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class CartController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function index(Request $request): array
    {
        // Массив id товаров.
        $productId = [];

        if ($request->expectsJson()) {
            //Валидация входных данных.
            $validator = Validator::make($request->json()->all(), [
                'products' => 'required|array',
                'products.*' => 'required|array:product,quantity',
                'products.*.product' => 'required|numeric',
                'products.*.quantity' => 'required|numeric|min:0|max:1000',
            ]);

            if(!$validator->fails()) {
                // Формируем массив id товаров.
                foreach ($validator->validated()['products'] as $el){
                    $productId[] = $el['product'];
                }
            }
        }

        return count($productId) > 0 ?
            StoreProduct::whereIn('store_products.id', $productId)
                ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
                ->select('store_products.id','store_products.name','article',
                    'price', 'old_price', 'available', DB::raw('"' . Storage::url(config('image.folder')).config('image.modification.fit.prefix') . '" as path'),
                    DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
                ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available')
                ->get()->toArray()
            : [];
        //Storage::url( config('image.folder').config('image.modification.fit.prefix')
    }
}
