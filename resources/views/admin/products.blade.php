<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Store Sections') }}
        </h2>
    </x-slot>
    <x-admin.alert message="{{$message}}" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
