<x-app-layout>

    <x-slot name="title">
        {{ __('admin/products.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/products.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-end p-2 text-gray-900 dark:text-gray-100 text-right border-b-2">
                    <x-admin.product-search />
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-admin.product-form
                        :id="$id"
                        :brand_array="$brand_array"
                        :data="$data"
                        :images="$images"
                      />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
