<?php

namespace App\Http\Controllers;

use App\Helpers\RecursionArray;
use App\Models\StoreProduct;
use App\Models\StoreSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(int $id = 0): View
    {
        // Определяем дочерние подразделы начального раздела.
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        $sections = RecursionArray::depth($array_all, $id, false, true);
        $sections[] = $id;

        //Выполняем выборку товаров и их изображений для раздела каталога.
        $products = StoreProduct::where(function ($query) use ($sections) {
            $query->whereIn('section', $sections);
            $query->where('visible', 1);
        })
            ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
            ->select('store_products.id','store_products.name','article', 'price', 'old_price', 'available',
                    DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
            ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available')
            ->paginate(cache('siteSettings')['catalog_numberItems']);

        return view('catalog', ['id' => $id, 'products' => $products]);
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'search'    => 'max:100',
        ]);

        if(!empty($validated['search'])) {

            $search = $validated['search'];

            $products = StoreProduct::where(function ($query) use ($search) {
                $query->whereRaw('`visible` = 1');
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('`article` = ?');
                    $query->orWhereRaw('MATCH(`store_products`.`name`) AGAINST(?)
                                  + MATCH(`store_products`.`description`) AGAINST(?)',
                        [$search, $search, $search]);
                });
            })
                ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
                ->selectRaw('store_products.id, store_products.name, article, price, old_price, available,
                    JSON_OBJECTAGG(store_images.name, store_images.sort) as images,
                    IF(`article` = ?, 1, 0) * 3
                    + MATCH(`store_products`.`name`) AGAINST(?) * 2
                    + MATCH(`store_products`.`description`) AGAINST(?) * 1
                    as relevant', [$search, $search, $search])
                ->selectRaw("IF(`available` > 0, 1, 0) AS `available_sort`")
                ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available', 'relevant')
                ->orderByDesc('available_sort')->orderByDesc('relevant')
                ->paginate(cache('siteSettings')['catalog_numberItems']);

            $products->appends([
                'search' => $search,
            ]);

            return view('catalog', ['id' => 0, 'search' => $search, 'products' => $products]);
        }
        else
            return view('catalog', ['id' => 0, 'search' => '', 'products' => []]);
    }
}
