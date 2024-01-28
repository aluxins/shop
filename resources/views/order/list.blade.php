<x-app-layout>

    <x-slot name="title">
        {{ __('order.list.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('order.list.heading') }}
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
                    __('order.nav.list') => '',
                    ]" />
            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="w-full">
                    <x-order.filter :filter="$filter" />
                </div>
                        <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 mt-6">
                            <thead>
                            <tr class="text-gray-500">
                                <td class="p-2">{{ __('order.list.order') }}</td>
                                <td class="p-2">{{ __('order.list.price') }}</td>
                                <td class="p-2 hidden sm:table-cell">{{ __('order.list.status') }}</td>
                                <td class="p-2 text-right">{{ __('order.list.info') }}</td>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2 flex justify-start items-center gap-4">
                                        <div class="h-min"><span class="text-sm text-gray-500">#</span>{{ $order['id'] }} <span class="timestamp text-sm text-gray-500">{{ $order['created_at'] }}</span>
                                            <div class="block sm:hidden text-sm text-gray-500 ">
                                                {{ $siteSettings['order_status'][$order['status']] ?? '' }} <span class="timestamp">{{ $order['updated_at'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-gray-500">{{ number_format($order['price'], 2) }}{!! cache('siteSettings')['currency_icon'] !!}</td>
                                    <td class="p-2 hidden sm:table-cell">{{ $siteSettings['order_status'][$order['status']] ?? '' }} <span class="timestamp text-sm text-gray-500">{{ $order['updated_at'] }}</span></td>
                                    <td class="p-2 text-right"><a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('order.id', ['id' => $order['id']]) }}">{{ __('order.list.view') }}</a></td>
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
