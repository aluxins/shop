<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($id): View|RedirectResponse
    {
        $product = StoreProduct::where(function ($query) use ($id) {
            $query->where('store_products.id', $id);
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

        if(is_null($product)) abort(404);

        return view('product',[
                'id' => $id,
                'product' => $product->toArray(),
            ]);
    }

}
