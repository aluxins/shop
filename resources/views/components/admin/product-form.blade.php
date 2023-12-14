@props([
    'id' => 0,
    'name' => !empty(old('name')) ?  : (!empty($data['name']) ? $data['name'] : ''),
    //!empty(old('name')) ? old('name') : (!empty($data['name']) ? $data['name'] : ''),
    'article' => old('article'),
    'description' => old('description'),
    'brand' => old('brand'),
    'brand_new' => old('brand_new'),
    'brand_array' => [],
    'price' => old('price'),
    'old_price' => old('old_price'),
    'available' => old('available'),
    'visible' => old('visible'),
    'section' => old('section'),
])

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
            Создание нового раздела
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
                        <x-menu.index idStart="0" type="select" :selected="($section)?$section:''" />
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
                            <option value="{{ $el['id'] }}" {{ ($brand == $el['id'])?'selected':'' }}>
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
                {{ __('Изображения') }}
            </td>
            <td>
                <label class="px-2">
                    <input type="file" name="images[]" multiple="multiple" class="m-1 w-3/4"
                           accept="image/png, image/jpeg, image/gif, image/webp" />
                </label>
            </td>
        </tr>
        </tbody>
    </table>
</form>
