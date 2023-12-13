<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreBrand;
use App\Models\StoreProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreProductsController extends Controller
{
    public function index(Request $request, $id = 0): \Illuminate\View\View
    {
        return View('admin.products', [
            'message' => $request->get('message'),
            'id' => $id,
            'brand' => StoreBrand::orderBy('name')->get()->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Валидация и insert новой категории.
     */
    public function store(Request $request, $id = 0): array //RedirectResponse
    {
        $id = (int) $id;
        $validated = $request->validate([
            'section' => 'required|integer|min:1',
            'name'    => 'required|string|max:256',
            'article'    => 'required|string|max:32|unique:store_products',
            'description' => 'max:65535',
            'brand' => 'nullable|integer',
            'brand_new' => 'nullable|string|max:256|unique:store_brands,name',
            'price' => 'required|numeric|between:0,999999.99',
            'old_price' => 'required|numeric|between:0,999999.99',
            'available' => 'integer',
            'visible' => 'required|boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|dimensions:max_width=3000,max_height=3000|size:5120',
         ]);

        $newProduct = new StoreProduct();

        //Добавляем название нового бренда и определяем ID
        if(!empty($validated['brand_new'])){
            $newBrand = new StoreBrand();
            $newBrand->name = $validated['brand_new'];
            $newBrand->save();
            $newProduct->brand = $newBrand->id;
        }
        else
            $newProduct->brand = $validated['brand'];

        $newProduct->section = $validated['section'];
        $newProduct->name = $validated['name'];
        $newProduct->article = $validated['article'];
        $newProduct->description = $validated['description'];
        $newProduct->price = $validated['price'];
        $newProduct->old_price = $validated['old_price'];
        $newProduct->available = $validated['available'];
        $newProduct->visible = $validated['visible'];


        /*
         * images
         */

        $newProduct->save();
        /*

        return redirect()->route('admin.storesections.index',
            ['message' => 'store', 'id' => $id]);
        */
        return $validated;
    }
}
