<x-app-layout>

    <x-slot name="title">
        {{ __('admin/sections.delete.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/sections.delete.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-admin.tree
                        :tree="$tree"
                        route="admin.sections.index" />
                    <form action="{{ route('admin.sections.destroy', ['id' => $id]) }}"
                          method="post" class="f-table">
                        @csrf
                        @method('delete')
                        <table class="container table-auto border border-collapse
                        border-gray-400 mx-auto shadow-lg">
                            <caption class="caption-top mt-3 text-lg font-medium">
                                {{ __('admin/sections.delete.question') }}
                            </caption>
                            <caption class="caption-bottom mt-3">
                                <button class="rounded-xl shadow-lg w-1/4 p-2 text-white
                                bg-red-500 hover:bg-red-600 hover:shadow-xl">
                                    {{ __('admin/sections.delete.button') }}
                                </button>
                            </caption>
                            <tbody>
                            <tr class="divide-x hover:bg-slate-50">
                                <td class="font-medium">
                                    <div class="flex flex-col space-y-4 m-4">
                                    @foreach($tree as $el)
                                        @if($el['id'] == $id)
                                            <div class="ml-1">
                                                [{{ $el['id'] }}] {{ $el['name'] }}
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach($delete as $el)
                                        <div class="ml-3">
                                            - [{{ $el['id'] }}] {{ $el['name'] }}
                                        </div>
                                  @endforeach
                                    </div>
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
