@props(['order'])
@php
    $obj = json_decode($order['name'], true);
        $total_price = 0;
        $products = [];
        if(is_array($obj)){
            foreach ($obj as $key => $val){
                $total = (json_decode($order['price'], true)[$key] ?? 0) * (json_decode($order['quantity'], true)[$key] ?? 0);
                $products[] = [
                    'product' => json_decode($order['product'], true)[$key] ?? '',
                    'name' => json_decode($order['name'], true)[$key] ?? '',
                    'quantity' => json_decode($order['quantity'], true)[$key] ?? '',
                    'price' => json_decode($order['price'], true)[$key] ?? '',
                    'total' => $total,
                    'image' => json_decode($order['image'], true)[$key] ?? ''
                ];
                $total_price += $total;
            }
        }
@endphp
<x-app-layout>

    <x-slot name="title">
        {{ __('admin/orders.id.title', ['id' => $id]) }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/orders.id.title', ['id' => $id]) }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a class="inline-flex items-center gap-1 px-2 py-1 m-2 text-md font-medium text-gray-600 hover:text-gray-900"
                   href="{{ route('admin.orders.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    <span class="underline">{{ __('admin/orders.id.back') }}</span>
                </a>

                <script type="module">
                    ConvertTimestamp.init("timestamp");
                </script>
                <div class="mx-4 my-2">
                    <div class="flex flex-wrap ">

                        <div class="p-2 w-full sm:w-1/2">
                            <div class="md:basis-1/2 border rounded-xl">
                                <div class="font-medium bg-gray-100 rounded-t-xl p-2 text-gray-900">{{ __('admin/orders.id.infoOrder') }}</div>

                                <div class="flex gap-2 p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800 text-clip overflow-hidden">
                                    <span class="">{{ __('admin/orders.id.totalPrice') }}</span>
                                    <span class="grow text-right">{{ number_format($total_price, 2) }}{!! cache('siteSettings')['currency_icon'] !!}</span>
                                </div>

                                <div class="flex gap-2 p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800 text-clip overflow-hidden">
                                    <span class="">{{ __('admin/orders.id.create') }}</span>
                                    <span class="timestamp grow text-right">{{ $order['created_at'] }}</span>
                                </div>

                                <div class="flex gap-2 p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800 text-clip overflow-hidden">
                                    <span class="">{{ __('admin/orders.id.change') }}</span>
                                    <span class="timestamp grow text-right">{{ $order['updated_at'] }}</span>
                                </div>

                                <div class="p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800 text-clip overflow-hidden">
                                    <form class="flex gap-2" method="post" action="{{ route('admin.orders.update', ['id' => $id]) }}">
                                        @csrf
                                        <span class="">{{ __('admin/orders.id.status') }}</span>
                                        <span class="grow text-right">
                                            <label>
                                                <select class="rounded-xl w-min" name="status">
                                                    <option hidden value="">{{ __('admin/orders.filter.status') }}</option>
                                                    @foreach((!empty($siteSettings['order_status']) and is_array($siteSettings['order_status']))
                                                        ? $siteSettings['order_status'] : [] as $key => $value)
                                                        <option value="{{ $key }}"{{ (isset($order['status']) and $key == $order['status']) ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </span>
                                        <button class="rounded-xl shadow-lg w-min p-2 text-white bg-sky-500 hover:bg-sky-600 hover:shadow-xl">
                                            {{ __('admin/orders.id.button') }}
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="p-2 w-full sm:w-1/2">
                            <div class="flex-col gap-2 hover:bg-gray-50 border rounded-xl">
                                <div class="font-medium bg-gray-100 rounded-t-xl p-2 text-gray-900">{{ __('admin/orders.id.infoUser') }}</div>
                                <div class="p-2 font-semibold">{{ __('admin/orders.id.fullName') }}: <span class="font-normal">{{ $order['full_name'] }}</span></div>
                                <div class="p-2 font-semibold">Email: <span class="font-normal">{{ $order['email'] }}</span></div>
                                <div class="p-2 font-semibold">{{ __('admin/orders.id.city') }}: <span class="font-normal">{{ $order['city'] }}</span></div>
                                <div class="p-2 font-semibold">{{ __('admin/orders.id.street') }}: <span class="font-normal">{{ $order['street_address'] }}</span></div>
                                <div class="p-2 font-semibold">{{ __('admin/orders.id.telephone') }}: <span class="font-normal">{{ $order['telephone'] }}</span></div>
                                <div class="p-2 font-semibold">{{ __('admin/orders.id.about') }}: <span class="font-normal">{{ $order['about'] }}</span></div>
                            </div>
                        </div>

                        <div class="p-2 w-full">
                            <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 mt-6">
                                <caption class="caption-top mb-4">
                                    {{ __('admin/orders.id.nameProducts') }}
                                </caption>
                                <caption class="caption-bottom pt-4 text-right">
                                    <x-admin.confirm
                                        name="{{ __('admin/orders.id.cancel') }}"
                                        url="{{ route('admin.orders.cancel', ['id' => $id]) }}"
                                        method="delete">
                                        {{ __('admin/orders.id.cancelTitle') }}
                                    </x-admin.confirm>
                                </caption>
                                <thead>
                                <tr class="text-gray-500">
                                    <td class="p-2">{{ __('admin/orders.id.product') }}</td>
                                    <td class="p-2 hidden sm:table-cell">{{ __('admin/orders.id.price') }}</td>
                                    <td class="p-2 hidden sm:table-cell">{{ __('admin/orders.id.price') }}</td>
                                    <td class="p-2 text-right">{{ __('admin/orders.id.info') }}</td>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr class="text-gray-500">
                                    <td class="p-2 hidden sm:table-cell"></td>
                                    <td class="p-2 text-right">{{ __('admin/orders.id.totalPrice') }}</td>
                                    <td class="p-2">{{ number_format($total_price, 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                                    <td class="p-2 hidden sm:table-cell"></td>
                                </tr>
                                </tfoot>
                                <tbody class="divide-y divide-gray-200">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="lg:p-2 flex justify-start items-center gap-4">
                                            <img src="{{ Storage::url(config('image.folder')).config('image.modification.fit.prefix'). (!empty($product['image']) ? $product['image'] : config('image.defaultSrc')) }}" alt="{{ $product['name'] }}" class="border w-16 h-16">
                                            <div class="h-min">{{ $product['name'] }}
                                                <div class="block sm:hidden text-sm text-gray-500">
                                                    <span class="text-nowrap">{{ $product['quantity'] }} x {{ number_format($product['price'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</span>
                                                    / <span class="text-nowrap">{{ __('admin/orders.id.price') }}: {{ number_format($product['total'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</span></div>
                                            </div>
                                        </td>
                                        <td class="p-2 hidden sm:table-cell text-gray-500 whitespace-nowrap">{{ $product['quantity'] }} x {{ number_format($product['price'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                                        <td class="p-2 hidden sm:table-cell text-gray-500">{{ number_format($product['total'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                                        <td class="p-2 text-right"><a class="font-medium text-sky-600 hover:text-sky-500" href="{{ route('product', ['id' => $product['product']]) }}">{{ __('admin/orders.id.view') }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
