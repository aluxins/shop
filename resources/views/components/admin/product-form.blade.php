@php
$arr = [
    'id' => 0,
    'brand_new' => old('brand_new'),
    'brand_array' => [],
    'images' => [],
    ];

$arr_for = [
    'name' => '',
    'article' => '',
    'description' => '',
    'brand' => 0,
    'price' => '0.00',
    'old_price' => '0.00',
    'available' => 0,
    'visible' => 1,
    'section' => 0,
    ];

foreach($arr_for as $key => $value)
        $arr[$key] = !empty(old($key)) ? old($key) : $data[$key] ?? $value;
@endphp
@props($arr)

<x-admin.error />

<form action="{{ route('admin.products.store', ['id' => $id]) }}"
      method="post" class="f-table" enctype="multipart/form-data">
    @csrf
    <table class="container table-auto border border-collapse
                        border-gray-400 mx-auto shadow-lg">
        <caption class="caption-top mt-3 text-lg font-medium">
            {{ $id ? 'Редактирование [ID: '.$id.']' : 'Создание' }}
        </caption>
        <caption class="caption-bottom mt-3">
            <button class="rounded-xl shadow-lg w-3/4 sm:w-1/2 md:w-1/4 p-2 text-white
                                bg-sky-500 hover:bg-sky-600 hover:shadow-xl">
                {{ __('admin/products.form.button') }}
            </button>
        </caption>
        <tbody class="divide-y text-center">
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                <span class="after:content-['*'] after:ml-0.5 after:text-red-500">{{ __('admin/products.form.name') }}</span>
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="name"
                           maxlength="255" value="{{ $name }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                <span class="after:content-['*'] after:ml-0.5 after:text-red-500">{{ __('admin/products.form.article') }}</span>
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="article"
                           maxlength="31" value="{{ $article }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                <span class="after:content-['*'] after:ml-0.5 after:text-red-500">{{ __('admin/products.form.section') }}</span>
            </td>
            <td>
                <label>
                    <select class="form-select w-3/4" name="section">
                        <option>{{ __('admin/products.form.select') }}:</option>
                        <x-menu.index idStart="0" type="select" :selected="$section" />
                    </select>
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.brand') }}
            </td>
            <td>
                <label>
                    <select class="form-select w-3/4" name="brand">
                        <option></option>
                        @foreach($brand_array as $el)
                            <option value="{{ $el['id'] }}" {{ ($brand == $el['id']) ? 'selected' : '' }}>
                            {{ $el['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" class="form-input m-1 w-3/4" name="brand_new"
                           title="" placeholder="{{ __('admin/products.form.newBrand') }}"
                           maxlength="255
                           " value="{{ $brand_new }}"
                    />

                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.price') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="price"
                           maxlength="9" value="{{ $price }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.oldPrice') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="old_price"
                           maxlength="9" value="{{ $old_price }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.available') }}
            </td>
            <td>
                <label>
                    <input type="number" class="form-input m-1 w-3/4" name="available"
                           min="0" maxlength="12" value="{{ $available }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.description') }}
            </td>
            <td>
                <label>
                    <textarea class="w-3/4" name="description">{{$description}}</textarea>
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.visible') }}
            </td>
            <td>
                <label class="px-2"> {{ __('Вкл') }}
                    <input type="radio" class="cursor-pointer" value="1" name="visible" {{ ($visible)?'checked':'' }} />
                </label>
                <label class="px-2"> {{ __('Выкл') }}
                    <input type="radio" class="cursor-pointer" value="0" name="visible" {{ ($visible)?'':'checked' }} />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.upload') }}
            </td>
            <td>
                <label class="px-2">
                    <input type="file" name="images[]" multiple="multiple" class="m-1 w-3/4"
                           accept="image/png, image/jpeg, image/gif, image/webp" />
                </label>
                <div class="text-gray-500 text-sm">Image: jpg, png, gif, webp. Max width x height: 3000x3000 px. Max size: 5 Mb.</div>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('admin/products.form.images') }}
            </td>
            <td class="flex flex-wrap gap-4 justify-center p-4">
                @foreach($images as $image)
                    <div class="border bg-slate-100 relative grid grid-cols-1 gap-1 justify-items-center content-between p-2 rounded w-fit">
                        <div class="absolute w-16 h-16 right-0">
                            <a href="{{route('admin.products.imageDelete', ['id' => $id, 'image' => $image['id']])}}"
                            title="{{ __('admin/products.form.deleteImage') }}">X</a>
                        </div>
                        <a class="w-1/2" target="_blank" href="{{Storage::url(
                            config('image.folder').config('image.modification.original.prefix').$image['name']
                                )}}">
                            <img class="m-auto" src="{{Storage::url(
                            config('image.folder').config('image.modification.th.prefix').$image['name']
                                )}}"  alt=""/>
                        </a>
                        <label>
                            <input class="w-1/2" name="sort[{{$image['id']}}]"
                                   value="{{!empty(old('sort')[$image['id']]) ?
                                   old('sort')[$image['id']] : $image['sort'] ?? 0}}" />
                        </label>
                    </div>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
</form>
<div class="w-full text-right">
    @if($id)
        <x-admin.confirm
            name="{{ __('admin/products.form.deleteProduct') }}"
            url="{{ route('admin.products.delete', ['id' => $id]) }}"
            method="delete">
                {{ __('admin/products.form.deleteText') }}
        </x-admin.confirm>
    @endif
</div>
