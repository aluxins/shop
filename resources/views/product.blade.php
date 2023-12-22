<x-app-layout>

    <header class="bg-white dark:bg-gray-800 shadow flex flex-row items-center p-5 justify-start">
        <x-menu.index idStart="{{$id}}" type="menu" />
        <!-- Logo -->
        <div class="shrink-0 flex items-center font-semibold text-xl text-gray-800 dark:text-gray-200 mx-5">
            <a href="{{ route('dashboard') }}" class="mx-2">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
            {{ __('Product') }}
        </div>

        <div class="grow flex flex-row justify-end">
            @include('layouts.navigation')

        </div>
    </header>

    <div class="py-12 mx-5">
        <div class="w-auto">
            <div class="">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <x-menu.index :idStart="$product['section']" type="tree" />

                            <div class="bg-white">
                                <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6 sm:py-8 lg:max-w-7xl lg:px-8">
                                    <x-product.product :product="$product" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
