<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreBrand;
use App\Models\StoreImage;
use App\Models\StoreProduct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class StoreProductsController extends Controller
{
    public function index(Request $request, $id = 0): View|RedirectResponse
    {
        $id = (int) $id;
        $product = StoreProduct::find($id);
        $images = StoreImage::where('product', $id)->orderBy('sort');
        return (!$id or $product) ?
            View('admin.products', [
                'message' => $request->get('message'),
                'id' => $id,
                'brand_array' => StoreBrand::orderBy('name')->orderBy('id')->get()->toArray(),
                'data' => $product ? $product->toArray() : [],
                'images' => $images ? $images->get()->toArray() : [],
            ])
        :
            redirect()->route('admin.products.index');
    }

    /**
     * Store a newly created resource in storage.
     * Валидация и insert новой категории.
     */
    public function store(Request $request, $id = 0): RedirectResponse
    {
        $id = (int) $id;

        //Валидация входных данных.
        $validated = $request->validate([
            'section' => 'required|integer|min:1',
            'name'    => 'required|string|max:255',
            'article'    => ['required','string','max:31',

                // Проверка уникальности поля article. Если редактируется товар и
                // артикул не изменился, то проверка не выполняется.
                Rule::when(
                    $id and $request->input('article') === StoreProduct::find($id)->article,
                    '',
                    'unique:store_products'
                    ),
                ],

            'description' => 'max:65534',
            'brand' => 'nullable|integer',
            'brand_new' => 'nullable|string|max:255|unique:store_brands,name',
            'price' => 'required|numeric|between:0,999999.99',
            'old_price' => 'required|numeric|between:0,999999.99',
            'available' => 'integer',
            'visible' => 'required|boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|mimes:jpg,png,gif,webp|dimensions:max_width=3000,max_height=3000|max:5120',
            'sort' => 'nullable|array',
            'sort.*' => 'nullable|numeric|min:-127|max:127',
         ]);

        $product = $id ? StoreProduct::find($id) : new StoreProduct();

        if($product) {

            //Добавляем название нового бренда и определяем ID.
            if (!empty($validated['brand_new'])) {
                $newBrand = new StoreBrand();
                $newBrand->name = $validated['brand_new'];
                $newBrand->save();
                $product->brand = $newBrand->id;
            } else
                $product->brand = $validated['brand'];

            $product->section = $validated['section'];
            $product->name = $validated['name'];
            $product->article = $validated['article'];
            $product->description = $validated['description'];
            $product->price = $validated['price'];
            $product->old_price = $validated['old_price'];
            $product->available = $validated['available'];
            $product->visible = $validated['visible'];

            $product->save();

            //Загрузка изображений.
            if (!empty($validated['images'])) {

                $insert = self::imageUpload(
                    $product->id,
                    config('image.folder'),
                    $request->file('images')
                );

                if (count($insert) > 0) {
                    StoreImage::insert($insert);
                }

            }

            //Сортировка изображений.
            if (!empty($validated['sort'])) {
                foreach($validated['sort'] as $key => $val){
                    StoreImage::where('id', $key)->where('product', $product->id)
                        ->update(['sort' => $val]);
                }
            }

            $request->session()->flash('message', $id ? 'update' : 'store');
            return redirect()->route('admin.products.index',
                ['id' => $product->id]);
        }
        else{
            $request->session()->flash('message', 'product-not-exists');
            return redirect()->route('admin.products.index');
          }
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $id = (int) $id;
        $product = StoreProduct::find($id);

        if($product) {
            self::imageDestroy($product->id);
            $product->delete();
            $request->session()->flash('message', 'product-delete');
        }
        else
            $request->session()->flash('message', 'product-not-exists');

        return redirect()->route('admin.products.index');
    }

    /**
     * @param Request $request
     * @param int $id
     * @param int $image
     * @return RedirectResponse
     */
    public function imageDelete(Request $request, int $id, int $image): RedirectResponse
    {
        self::imageDestroy($id, $image) ?
            $request->session()->flash('message', 'image-delete')
            :
            $request->session()->flash('message', 'image-not-exists');

        return redirect()->route('admin.products.index', ['id' => $id]);
    }

    /**
     * Загрузка изображений.
     * Изменение размера изображения при превышении одной из сторон.
     * Создание уменьшенных копий изображения.
     * @param int $id
     * @param string $folder
     * @param array $images
     * @return array
     */
    public function imageUpload(int $id, string $folder, array $images): array
    {
        $insert = [];
        foreach ($images as $file) {

            //Массив данных для вставки в БД.
            $insert[] = [
                'product' => $id,
                'sort' => 0,
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
            $img->save(Storage::path($folder) . config('image.modification.original.prefix') . $img_name);

            $img_th = Image::make($img_tmp)->
            resize(config('image.modification.th.resize'), config('image.modification.th.resize'),
                function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            $img_th->save(Storage::path($folder) . config('image.modification.th.prefix') . $img_name);

            $img_th_fit = Image::make($img_tmp)->fit(config('image.modification.fit.resize'));
            $img_th_fit->save(Storage::path($folder) . config('image.modification.fit.prefix') . $img_name);
        }
        return $insert;
    }

    /**
     * Удаление изображения и его уменьшенных копий.
     * @param int $id
     * @param int $product
     * @return bool
     */
    public function imageDestroy(int $product, int $id = 0): bool
    {
        $images = StoreImage::where('product', $product)
            ->where(function($query) use ($id){
                if($id != 0)$query->where('id', $id);
            })->get();

        if($images) {
            foreach ($images as $image) {
                $img_name = $image->name;

                $folder = config('image.folder');
                Storage::delete([
                    $folder . config('image.modification.original.prefix') . $img_name,
                    $folder . config('image.modification.th.prefix') . $img_name,
                    $folder . config('image.modification.fit.prefix') . $img_name,
                ]);

                $image->delete();
            }
            return true;
        }
        else return false;
    }

    /**
     * Поиск товара по артикулу или ID
     * @param Request $request
     * @return RedirectResponse
     */
    public function search(Request $request): RedirectResponse
    {
        //Валидация входных данных.
        $validated = $request->validate([
            'searchId' => 'nullable|required_without:searchArticle|integer|min:1',
            'searchArticle'    => 'nullable|required_without:searchId|string|max:32',
        ]);

            $product = StoreProduct::
                where(function($query) use ($validated){
                    if($validated['searchId'] != 0)$query->where('id', $validated['searchId']);
                })
                ->where(function($query) use ($validated){
                    if($validated['searchArticle'] != 0)$query->where('article', $validated['searchArticle']);
                })->first();

        if(!$product)
            $request->session()->flash('message', 'product-not-exists');

        return redirect()->route('admin.products.index', ['id' => $product->id ?? 0]);
    }
}
