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
        $arr[$key] = !empty(old()) ? old($key) : $data[$key] ?? $value;
@endphp
@props($arr)

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.store', ['id' => $id]) }}"
      method="post" class="f-table" enctype="multipart/form-data">
    @csrf
    <table class="container table-auto border border-collapse
                        border-gray-400 mx-auto shadow-lg">
        <caption class="caption-top mt-3 text-lg font-medium">
            {{ $id ? 'Редактирование' : 'Создание' }}
        </caption>
        <caption class="caption-bottom mt-3">
            <button class="rounded-xl shadow-lg w-1/4 p-2 text-white
                                bg-sky-500 hover:bg-sky-600 hover:shadow-xl">
                Сохранить
            </button>
        </caption>
        <tbody class="divide-y text-center">
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Название') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="name"
                           maxlength="256" value="{{ $name }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Артикул') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="article"
                           maxlength="32" value="{{ $article }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Раздел') }}
            </td>
            <td>
                <label>
                    <select class="form-select w-3/4" name="section">
                        <option>Выберите раздел:</option>
                        <x-menu.index idStart="0" type="select" :selected="$section" />
                    </select>
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Бренд') }}
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
                           title="" placeholder="Новый бренд"
                           maxlength="256" value="{{ $brand_new }}"
                    />

                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Цена') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="price"
                           maxlength="11" value="{{ $price }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Старая цена') }}
            </td>
            <td>
                <label>
                    <input type="text" class="form-input m-1 w-3/4" name="old_price"
                           maxlength="11" value="{{ $old_price }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Количество') }}
            </td>
            <td>
                <label>
                    <input type="number" class="form-input m-1 w-3/4" name="available"
                           maxlength="12" value="{{ $available }}" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Описание') }}
            </td>
            <td>
                <label>
                    <textarea class="w-3/4" name="description">{{$description}}</textarea>
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Видимость') }}
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
                {{ __('Загрузить') }}
            </td>
            <td>
                <label class="px-2">
                    <input type="file" name="images[]" multiple="multiple" class="m-1 w-3/4"
                           accept="image/png, image/jpeg, image/gif, image/webp" />
                </label>
            </td>
        </tr>
        <tr class="divide-x hover:bg-slate-50">
            <td class="font-medium">
                {{ __('Изображения') }}
            </td>
            <td class="flex flex-wrap gap-4 justify-center p-4">
                @foreach($images as $image)
                    <div class="border bg-slate-100 relative grid grid-cols-1 gap-1 justify-items-center content-between p-2 rounded w-fit">
                        <div class="absolute w-16 h-16 right-0">
                            <a href="{{route('admin.products.imageDelete', ['id' => $id, 'image' => $image['id']])}}"
                            title="Удалить изображение?">X</a>
                        </div>
                        <a class="w-1/2" target="_blank" href="{{Storage::url(
                            config('image.folder').config('image.modification.original.prefix').$image['name']
                                )}}">
                            <img class="m-auto" src="{{Storage::url(
                            config('image.folder').config('image.modification.th.prefix').$image['name']
                                )}}"  alt=""/>
                        </a>
                        <label>
                            <input class="w-1/2" name="sort[]" value="{{$image['sort']}}" />
                        </label>
                    </div>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
</form>
<div class="w-full text-right">
    <form method="post" action="{{route('admin.products.delete', ['id' => $id])}}">
        @csrf
        {{ method_field('DELETE') }}
    <button>
        Удалить товар
    </button>
    </form>
</div>
