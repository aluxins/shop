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
    <form action="{{$action}}" method="post" class="f-table">
        @if ($method === "PATCH" or $method === "PUT")
            @method($method)
        @endif

        @csrf
        <table class="container table-auto border border-collapse border-gray-400 mx-auto
        shadow-lg">
            <caption class="caption-bottom mt-3">
                <button class="rounded-xl shadow-lg w-1/4 p-2 text-white bg-sky-500
                hover:bg-sky-600 hover:shadow-xl">
                    Сохранить
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
                        {{$el->id}}
                    </td>
                    <td>
                        <input type="text" class="form-input m-1" value="{{$el->name}}"
                               name="name[{{$el->id}}]" />
                    </td>
                    <td>
                        <input type="number" class="form-input m-1 w-20" value="{{$el->sort}}"
                               name="sort[{{$el->id}}]" />
                    </td>
                    <td>
                        <input type="radio" class="" value="0" name="visible[{{$el->id}}]"
                               {{($el->visible)?'':'checked'}} />
                        <input type="radio" class="" value="1" name="visible[{{$el->id}}]"
                            {{($el->visible)?'checked':''}}/>
                    </td>
                    <td>
                        <input type="radio" class="" value="0" name="link[{{$el->id}}]"
                            {{($el->link)?'':'checked'}} />
                        <input type="radio" class="" value="1" name="link[{{$el->id}}]"
                            {{($el->link)?'checked':''}}/>
                    </td>
                    <td>
                        <a href="{{$action}}/{{$el->parent}}">&#10606;</a>
                        <a href="{{$action}}/{{$el->parent}}">&#10007;</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>
