<x-app-layout>

    <x-slot name="title">
        {{ __('admin/sections.new.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/sections.new.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-admin.tree
                        :tree="$tree"
                        route="admin.sections.index" />
                    <form action="{{ route('admin.sections.store', ['id' => $id]) }}"
                          method="post" class="f-table">
                    @csrf
                        <table class="container table-auto border border-collapse
                        border-gray-400 mx-auto shadow-lg">
                            <caption class="caption-bottom mt-3">
                                <button class="rounded-xl shadow-lg w-1/4 p-2 text-white
                                bg-sky-500 hover:bg-sky-600 hover:shadow-xl">
                                    {{ __('admin/sections.new.save') }}
                                </button>
                            </caption>
                            <tbody class="divide-y text-center">
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('admin/sections.new.name') }}
                                    </td>
                                    <td>
                                        <label>
                                            <input type="text" class="form-input m-1 w-3/4" name="name"
                                                   maxlength="64" />
                                        </label>
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('admin/sections.new.sort') }}
                                    </td>
                                    <td>
                                        <label>
                                            <input type="number" class="form-input m-1 w-20" value="100"
                                                   name="sort" />
                                        </label>
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('admin/sections.new.visible') }}
                                    </td>
                                    <td>
                                        <label class="px-2"> {{ __('admin/sections.new.on') }}
                                            <input type="radio" class="cursor-pointer" value="1" name="visible" checked />
                                        </label>
                                        <label class="px-2"> {{ __('admin/sections.new.off') }}
                                            <input type="radio" class="cursor-pointer" value="0" name="visible" />
                                        </label>
                                    </td>
                                </tr>
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('admin/sections.new.url') }}
                                    </td>
                                    <td>
                                        <label class="px-2"> {{ __('admin/sections.new.on') }}
                                            <input type="radio" class="cursor-pointer" value="1" name="link" checked />
                                        </label>
                                        <label class="px-2"> {{ __('admin/sections.new.off') }}
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
