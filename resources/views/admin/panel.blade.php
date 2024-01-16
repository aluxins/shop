@props(['tables'])
<x-app-layout>

    <x-slot name="title">
        {{ __('admin/panel.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/panel.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 content-stretch md:grid-cols-3 gap-4 p-4">
                    @foreach([
                        'orders' => 'store_orders',
                        'products' => 'store_products',
                        'sections' => 'store_sections',
                        'pages' => 'store_pages',
                        'panel' => 'users',
                        'settings' => 'store_settings',
                        ] as $key => $val)
                        <a href="{{ route('admin.' . $key . '.index') }}">
                            <div class=" rounded-2xl bg-gray-50 hover:bg-gray-100 shadow hover:shadow-md p-2 cursor-pointer">
                                <div class="text-lg font-semibold antialiased border-b text-center p-2">{{ __('admin/panel.' . $key) }}</div>
                                <div class="text-center text-md p-2">{{ __('admin/panel.total') }}
                                    <span class="text-xl">
                                        {{ $tables[array_search($val, array_column($tables, 'TABLE_NAME'))]->TABLE_ROWS }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
