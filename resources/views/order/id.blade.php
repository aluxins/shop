@props(['id', 'order'])
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
        {{ __('order.id.title', ['id' => $id]) }}
    </x-slot>

    <x-slot name="heading">
        {{ __('order.id.heading', ['id' => $id]) }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <script type="module">
        ConvertTimestamp.init("timestamp");
    </script>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-account-nav :array="[
                    __('order.nav.list') => route('order.index'),
                    __('order.nav.id', ['id' => $id]) => '',
                    ]" />
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="flex flex-col sm:flex-row justify-between bg-gray-50 rounded-xl p-2">
                    <div class="flex flex-row sm:flex-col justify-between border-b sm:border-0 py-4">
                        <div class="font-semibold">{{ __('order.id.order') }}</div>
                        <div class="text-gray-500">#{{ $order['id'] }}</div>
                    </div>
                    <div class="flex flex-row sm:flex-col justify-between border-b sm:border-0 py-4">
                        <div class="font-semibold">{{ __('order.id.placed') }}</div>
                        <div class="text-gray-500"><span class="timestamp">{{ $order['created_at'] }}</span></div>
                    </div>
                    <div class="flex flex-row sm:flex-col justify-between border-b sm:border-0 py-4">
                        <div class="font-semibold">{{ __('order.id.status') }}</div>
                        <div class="text-gray-500">{{ $siteSettings['order_status'][$order['status']] ?? '' }} <span class="timestamp text-sm">{{ $order['updated_at'] }}</span></div>
                    </div>
                    <div class="flex flex-row sm:flex-col justify-between py-4">
                        <div class="font-semibold">{{ __('order.id.total') }}</div>
                        <div class="text-gray-500">{{ number_format($total_price, 2) }}{!! cache('siteSettings')['currency_icon'] !!}</div>
                    </div>
                </div>
                <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 mt-6">
                    <thead>
                        <tr class="text-gray-500">
                            <td class="p-2">{{ __('order.id.product') }}</td>
                            <td class="p-2 hidden sm:table-cell">{{ __('order.id.price') }}</td>
                            <td class="p-2 hidden sm:table-cell">{{ __('order.id.totalPrice') }}</td>
                            <td class="p-2 text-right">{{ __('order.id.info') }}</td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="text-gray-500">
                            <td class="p-2 hidden sm:table-cell"></td>
                            <td class="p-2 text-right">{{ __('order.id.totalPrice') }}</td>
                            <td class="p-2">{{ number_format($total_price, 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                            <td class="p-2 hidden sm:table-cell"></td>
                        </tr>
                    </tfoot>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="lg:p-2 flex justify-start items-center gap-4">
                                <img src="{{ Storage::url(config('image.folder')).config('image.modification.fit.prefix').$product['image'] }}" alt="{{ $product['name'] }}" class="border w-16 h-16">
                                <div class="h-min">{{ $product['name'] }}
                                    <div class="block sm:hidden text-sm text-gray-500">
                                        <span class="text-nowrap">{{ $product['quantity'] }} x {{ number_format($product['price'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</span>
                                        / <span class="text-nowrap">{{ __('order.id.totalPrice') }}: {{ number_format($product['total'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</span></div>
                                </div>
                            </td>
                            <td class="p-2 hidden sm:table-cell text-gray-500 whitespace-nowrap">{{ $product['quantity'] }} x {{ number_format($product['price'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                            <td class="p-2 hidden sm:table-cell text-gray-500">{{ number_format($product['total'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                            <td class="p-2 text-right"><a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('product', ['id' => $product['product']]) }}">{{ __('order.id.view') }}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
