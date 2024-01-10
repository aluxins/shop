<x-app-layout>

    <x-slot name="title">
        История заказов
    </x-slot>

    <x-slot name="heading">
        История заказов
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <script type="module">
        ConvertTimestamp.init("timestamp");
    </script>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full">
                    <x-order.filter />
                </div>
                        <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 mt-6">
                            <thead>
                            <tr class="text-gray-500">
                                <td class="p-2">Order</td>
                                <td class="p-2">Price</td>
                                <td class="p-2 hidden sm:table-cell">Status</td>
                                <td class="p-2 text-right">Info</td>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2 flex justify-start items-center gap-4">
                                        <div class="h-min">{{ $order['id'] }} <span class="timestamp text-sm text-gray-500">{{ $order['created_at'] }}</span>
                                            <div class="block sm:hidden text-sm text-gray-500 ">
                                                {{ $order['status'] }} {{ $order['updated_at'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-gray-500 after:content-['{{ __('currency-icon') }}']">{{ number_format($order['price'], 2) }}</td>
                                    <td class="p-2 hidden sm:table-cell">{{ $order['status'] }} <span class="timestamp text-sm text-gray-500">{{ $order['updated_at'] }}</span></td>
                                    <td class="p-2 text-right"><a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('order.index', ['id' => $order['id']]) }}">view</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                <div class="p-4">
                    {{ $orders->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
