<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreBrand;
use App\Models\StoreImage;
use App\Models\StoreProduct;
//use Illuminate\Contracts\Foundation\Application;
//use Illuminate\Contracts\View\Factory;
//use Illuminate\Contracts\View\View;
//use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

//use Intervention\Image\Facades\Image as Image;
//use Intervention\Image\ImageManagerStatic as Image;

class StoreProductsController extends Controller
{
    public function index(Request $request, $id = 0): \Illuminate\View\View
    {
        $id = (int) $id;
        return View('admin.products', [
            'message' => $request->get('message'),
            'id' => $id,
            'brand_array' => StoreBrand::orderBy('name')->get()->toArray(),
            'data' => $id ? StoreProduct::find($id)->toArray():[],
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
            'images.*' => 'nullable|mimes:jpg,png,gif,webp|dimensions:max_width=3000,max_height=3000|max:5120',
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

        $newProduct->save();

        /*
         * Загрузка изображений.
         * Изменение размера изображения при превышении одной из стороны.
         * Создание уменьшенных копий изображения.
        */

        if(!empty($validated['images'])){
            $insert = [];
            $folder = config('image.folder');

            foreach($request->file('images') as $key => $file) {

                $insert[] = [
                    'product' => $newProduct->id,
                    'sort' => $key,
                    'name' => $file->hashName(),
                ];

                $img_tmp = $file->getPathname();
                $img_name = $file->hashName();

                $img = Image::make($img_tmp)->
                resize(config('image.modification.original.resize'), config('image.modification.original.resize'),
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                $img->save(Storage::path($folder).config('image.modification.original.prefix').$img_name);

                $img_th = Image::make($img_tmp)->
                resize(config('image.modification.th.resize'), config('image.modification.th.resize'),
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                $img_th->save(Storage::path($folder).config('image.modification.th.prefix').$img_name);

                $img_th_fit = Image::make($img_tmp)->fit(config('image.modification.fit.resize'));
                $img_th_fit->save(Storage::path($folder).config('image.modification.fit.prefix').$img_name);
            }

            if (count($insert) > 0){
                StoreImage::insert($insert);
            }

        }

        /*

        return redirect()->route('admin.storesections.index',
            ['message' => 'store', 'id' => $id]);
        */
        return [$validated, $insert];
    }
}
