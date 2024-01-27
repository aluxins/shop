<?php

namespace App\Http\Controllers;

use App\Helpers\RecursionArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Repositories\Interfaces\ProductsRepositoryInterface;

class CatalogController extends Controller
{
    public function index(Request $request, ProductsRepositoryInterface $productsRepository, $id = 0): View
    {

        // Валидация данных из формы
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                    'brands' => [
                        'nullable',
                        'array'
                    ],
                    'brands.*' => [
                        'numeric'
                    ]
                ]
            );

            $brands = $validator->valid()['brands'] ?? [];
        }

        // Валидация данных из get строки
        else {
            $validator = Validator::make($request->all(), [
                    'brands' => [
                        'nullable',
                        'regex:/^[0-9_]+$/i'
                    ]
                ]
            );

            $brands = !empty($validator->valid()['brands'])
                ? explode('_', $validator->valid()['brands'])
                : [];
        }

        // Определяем дочерние подразделы начального раздела.
        $array_all = cache('sections-db') ?? [];
        $sections = RecursionArray::depth($array_all, $id, false, true);
        $sections[] = $id;

        // Параметры.
        $settings = self::settings($request);

        //Выполняем выборку товаров и их изображений для раздела и подразделов каталога.
        $products = $productsRepository->getProductsBySections($sections,$brands, $settings['orderBy'])
            ->paginate($settings['paginate']);

        // Добавляем ID брендов в url пагинатора (?brands=1_2_3...).
        $products->appends([
            'brands' => implode('_', $brands),
        ]);

        return view('catalog', ['id' => $id, 'sections' => $sections, 'brands' => $brands, 'products' => $products]);
    }

    public function search(Request $request, ProductsRepositoryInterface $productsRepository): View
    {
        $validated = $request->validate([
            'search'    => 'string|max:100',
        ]);

        if(!empty($validated['search'])) {

            // Поисковый запрос.
            $search = $validated['search'];

            // Параметры.
            $settings = self::settings($request);

            // Выполняем поиск товаров.
            $products = $productsRepository->searchProducts($search, $settings['orderBy'])
                ->paginate($settings['paginate']);

            // Добавляем запрос в url пагинатора
            $products->appends([
                'search' => $search,
            ]);

        }

        return view('catalog', ['id' => 0, 'search' => $search ?? '', 'sections' => [], 'brands' => [], 'products' => $products ?? []]);
    }

    /**
     * Параметры каталога товаров.
     * @param $request
     * @return array
     */
    private static function settings($request): array
    {
        return [
        'orderBy' => $request->session()->get('catalog_settings')['sort']
            ?? config('app.store_settings')['catalog']['sort']['default'],
        'paginate' => $request->session()->get('catalog_settings')['count']
            ?? config('app.store_settings')['catalog']['count']['default'],
        ];
    }
}
