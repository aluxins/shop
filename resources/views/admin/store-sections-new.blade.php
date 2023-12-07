<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Store Sections') }}
        </h2>
    </x-slot>
    <x-admin.alert message="{{ $message }}" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-admin.tree
                        :tree="$tree"
                        route="admin.storesections.index" />
                    <form action="{{ route('admin.storesections.store', ['id' => $id]) }}"
                          method="post" class="f-table">
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
                                        {{ __('Название раздела') }}
                                    </td>
                                    <td>
                                        <input type="text" class="form-input m-1 w-3/4" name="name"
                                               maxlength="64" />
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('Сортировка') }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-input m-1 w-20" value="100"
                                               name="sort" />
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('Видимость') }}
                                    </td>
                                    <td>
                                        <label class="px-2"> {{ __('Вкл') }}
                                            <input type="radio" class="cursor-pointer" value="1" name="visible" checked />
                                        </label>
                                        <label class="px-2"> {{ __('Выкл') }}
                                            <input type="radio" class="cursor-pointer" value="0" name="visible" />
                                        </label>
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('Гиперссылка') }}
                                    </td>
                                    <td>
                                        <label class="px-2"> {{ __('Вкл') }}
                                            <input type="radio" class="cursor-pointer" value="1" name="link" checked />
                                        </label>
                                        <label class="px-2"> {{ __('Выкл') }}
                                            <input type="radio" class="cursor-pointer" value="0" name="link" />
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
