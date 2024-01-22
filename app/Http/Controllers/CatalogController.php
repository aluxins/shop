<?php

namespace App\Http\Controllers;

use App\Helpers\RecursionArray;
use App\Models\StoreProduct;
use App\Models\StoreSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, $id = 0): View
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
        }
        else {
            // Валидация данных из get строки
            $validator = Validator::make($request->all(), [
                    'brands' => [
                        'nullable',
                        'regex:/^[0-9_]+$/i'
                    ]
                ]
            );
        }

        // Фильтр по брендам. Массив ID брендов.
        $brands = $request->isMethod('post')
            ? $validator->valid()['brands'] ?? []
            : (!empty($validator->valid()['brands'])
                ? explode('_', $validator->valid()['brands'])
                : []);

        // Определяем дочерние подразделы начального раздела.
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        $sections = RecursionArray::depth($array_all, $id, false, true);
        $sections[] = $id;

        // Параметры.
        $orderBy = $request->session()->get('catalog_settings')['sort']
            ?? config('app.store_settings')['catalog']['sort']['default'];
        $paginate = $request->session()->get('catalog_settings')['count']
            ?? config('app.store_settings')['catalog']['count']['default'];

        //Выполняем выборку товаров и их изображений для раздела и подразделов каталога.
        $products = StoreProduct::where(function ($query) use ($sections, $brands) {
            $query->where('visible', 1);
            $query->whereIn('section', $sections);
            if(count($brands) > 0)$query->whereIn('brand', $brands);
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
            })
            ->paginate($paginate);

        // Добавляем ID брендов в url пагинатора (?brands=1_2_3...).
        $products->appends([
            'brands' => implode('_', $brands),
        ]);

        return view('catalog', ['id' => $id, 'sections' => $sections, 'brands' => $brands, 'products' => $products]);
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'search'    => 'string|max:100',
        ]);

        if(!empty($validated['search'])) {

            // Поисковый запрос.
            $search = $validated['search'];

            // Параметры.
            $orderBy = $request->session()->get('catalog_settings')['sort']
                ?? config('app.store_settings')['catalog']['sort']['default'];
            $paginate = $request->session()->get('catalog_settings')['count']
                ?? config('app.store_settings')['catalog']['count']['default'];

            $products = StoreProduct::where(function ($query) use ($search) {
                $query->whereRaw('visible = 1');
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('article = ?');
                    $query->orWhereRaw('MATCH(store_products.name) AGAINST(?)
                                  + MATCH(store_products.description) AGAINST(?)',
                        [$search, $search, $search]);
                });
            })
                ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
                ->selectRaw('store_products.id, store_products.name, article, price, old_price, available,
                    JSON_OBJECTAGG(store_images.name, store_images.sort) as images,
                    IF(article = ?, 1, 0) * 3
                    + MATCH(store_products.name) AGAINST(?) * 2
                    + MATCH(store_products.description) AGAINST(?) * 1
                    as relevant', [$search, $search, $search])
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
                })
                ->paginate($paginate);

            // Добавляем запрос в url пагинатора
            $products->appends([
                'search' => $search,
            ]);

            return view('catalog', ['id' => 0, 'search' => $search, 'sections' => [], 'brands' => [], 'products' => $products]);
        }
        else
            return view('catalog', ['id' => 0, 'search' => '', 'sections' => [], 'brands' => [], 'products' => []]);
    }
}
