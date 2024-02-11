<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProductsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request, ProductsRepositoryInterface $productsRepository): JsonResponse
    {
        // Массив id товаров.
        $productsId = [];

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
                foreach ($validator->valid()['products'] as $el){
                    $productsId[] = $el['product'];
                }
            }
        }

        $products = [];
        if(count($productsId)) {
            // Запрос товаров.
            $products = $productsRepository->cartProducts($productsId);

            // Добавляем к товарам path изображений. Если изображение отсутствует - устанавливаем изображение по умолчанию.
            foreach ($products as $key => $product) {
                if (is_null($product['images'])) $products[$key]['images'] = json_encode([config('image.defaultSrc') => 0]);
                $products[$key]['path_images'] = Storage::url(config('image.folder')) . config('image.modification.fit.prefix');
                $products[$key]['path_products'] = route('product');
            }
        }

        return response()->json($products);
    }
}
