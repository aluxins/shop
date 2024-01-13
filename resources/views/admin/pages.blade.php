<x-app-layout>
    <x-admin.navigation />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('admin/pages.titleList') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
                    <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 mt-6">
                        <caption class="caption-top text-right p-4">
                            <a class="underline" href="{{ route('admin.pages.index', ['id' => -1]) }}">
                                {{ __('admin/pages.create') }}
                            </a>
                        </caption>
                        <thead>
                        <tr class="text-gray-500">
                            <td class="p-2">{{ __('admin/pages.page') }}</td>
                            <td class="p-2 hidden sm:table-cell">{{ __('admin/pages.url') }}</td>
                            <td class="p-2 hidden sm:table-cell">{{ __('admin/pages.sort') }}</td>
                            <td class="p-2 text-right"> </td>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pages as $page)
                            <tr class="hover:bg-gray-50">
                                <td class="p-2 flex justify-start items-center gap-4">
                                    <div class="h-min">{{ $page['name'] }}
                                        <div class="block sm:hidden text-sm text-gray-500 ">
                                            <div>{{ __('admin/pages.url') }}: <span class="">{{ $page['url'] }}</span></div>
                                            <div>{{ __('admin/pages.sort') }}: <span class="">{{ $page['sort'] }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 hidden sm:table-cell">{{ $page['url'] }}</td>
                                <td class="p-2 hidden sm:table-cell">{{ $page['sort'] }}</td>
                                <td class="p-2 text-right">
                                    <a class="font-medium text-indigo-600 hover:text-indigo-500"
                                       href="{{ route('admin.pages.update', ['id' => $page['id']]) }}">{{ __('admin/pages.edit') }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</x-app-layout>
