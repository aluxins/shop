@props(['products'])
<x-app-layout>

    <x-slot name="title">
        {{ __("catalog.title") }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => true])
    </x-slot>

        <div class="w-[300px] hidden pt-5 lg:block float-left">
        </div>

        <div class="w-auto">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 sm:p-4 text-gray-900 dark:text-gray-100">
                        <x-menu.index idStart="{{$id}}" type="tree" />

                        <div class="bg-white">
                            <div class="mx-auto max-w-1xl px-4 py-10 sm:px-6 sm:py-8 lg:max-w-7xl lg:px-8">
                                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                                    @if(isset($search))
                                        <div class="text-sm font-normal">
                                            {{ __('catalog.onRequest') }}
                                            <span class="italic">
                                                &#171;{{ $search }}&#187;
                                            </span>
                                        </div>
                                        {{ __('catalog.search') }}
                                    @else
                                        @yield('nameSection')
                                    @endif

                                        {{ declensionWord(!empty($products) ? $products->total() : 0, [
                                                __("catalog.declension1"),
                                                __("catalog.declension2"),
                                                __("catalog.declension3")
                                            ]) }}

                                </h2>
                                <div class="my-6 grid grid-cols-1 gap-x-4 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($products as $product)
                                        <x-catalog.product :product="$product" />
                                    @endforeach
                                </div>
                                 {{ !empty($products) ? $products->onEachSide(1)->links() : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</x-app-layout>
