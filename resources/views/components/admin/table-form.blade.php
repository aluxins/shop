{{--
    <x-admin.table-form
        :action="route('name_controller')"  # URL-адрес
        method="post"                       # Метод post или get
        thead=";Столбец1;Стобец2;Столбец3"  # Имена столбцов в шапке таблицы
        :tbody="$object"                    # Данные таблицы, тип object
     />
--}}
<div>
    <script type="module">
        onlyChangedData("f-table");
    </script>
    <form action="{{route('admin.sections.update', $id)}}" method="post" class="f-table">
        @if ($method == "PATCH" or $method == "PUT")
            @method($method)
        @endif

        @csrf
        <table class="container table-auto border border-collapse border-gray-400 mx-auto
        shadow-lg">
            <caption class="caption-top text-right p-4">
                <a class="underline" href="{{route('admin.sections.create', $id)}}">
                    {{ __('admin/sections.create') }}
                </a>
            </caption>
            <caption class="caption-bottom mt-3">
                <button class="rounded-xl shadow-lg w-1/4 p-2 text-white bg-sky-500
                hover:bg-sky-600 hover:shadow-xl">
                    {{ __('admin/sections.save') }}
                </button>
            </caption>
            <thead>
            <tr class="bg-slate-50 divide-x">
                @foreach($thead as $val)
                    <th class="p-2">{{$val}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody class="divide-y text-center">
            @foreach($tbody as $el)
                <tr class="divide-x hover:bg-slate-50">
                    <td class="font-medium">
                        {{$el['id']}}
                    </td>
                    <td>
                        <label>
                            <input type="text" class="form-input m-1 w-3/4" value="{{$el['name']}}"
                                   name="name[{{$el['id']}}]" maxlength="64" />
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="number" class="form-input m-1 w-20" value="{{$el['sort']}}"
                                   name="sort[{{$el['id']}}]" />
                        </label>
                    </td>
                    <td>
                        <label class="px-2">
                            <input type="radio" class="cursor-pointer" value="1" name="visible[{{$el['id']}}]"
                                {{($el['visible'])?'checked':''}}/>
                        </label>
                        <label class="px-2">
                            <input type="radio" class="cursor-pointer" value="0" name="visible[{{$el['id']}}]"
                                   {{($el['visible'])?'':'checked'}} />
                        </label>
                    </td>
                    <td>
                        <label class="px-2">
                            <input type="radio" class="cursor-pointer" value="1" name="link[{{$el['id']}}]"
                                {{($el['link'])?'checked':''}}/>
                        </label>
                        <label class="px-2">
                            <input type="radio" class="cursor-pointer" value="0" name="link[{{$el['id']}}]"
                                {{($el['link'])?'':'checked'}} />
                        </label>
                    </td>
                    <td class="px-2">
                        <div class="flex flex-row justify-between gap-2">
                            <a class="border p-2 rounded hover:bg-gray-200" href="{{route('admin.sections.index', $el['id'])}}">{{ __('admin/sections.enter') }}</a>
                            <a class="border p-2 rounded hover:bg-gray-200" href="{{route('admin.sections.delete', $el['id'])}}">X</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>
