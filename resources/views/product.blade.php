<x-app-layout>

    <x-slot name="title">
        {{ $product['name'] }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <script type="module">
        Cart.add("cart");
    </script>

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


</x-app-layout>
