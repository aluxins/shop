<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, int $id = 0): View
    {
        //Выполняем выборку товаров и их изображений для раздела каталога.
        return view('catalog', [
            'id' => $id,
            'products' => StoreProduct::where(function ($query) use ($id) {
                $query->where('section', $id);
                $query->where('visible', 1);
            })
                ->leftJoin('store_images', 'store_products.id', '=', 'store_images.product')
                ->select('store_products.id','store_products.name','article',
                    'price', 'old_price', 'available',
                    DB::raw('JSON_OBJECTAGG(store_images.name, store_images.sort) as images'))
                ->groupBy('id', 'name', 'article', 'price', 'old_price', 'available')
                ->paginate(6),
        ]);
    }
}
