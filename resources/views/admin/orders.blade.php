<x-app-layout>

    <x-slot name="title">
        {{ __('admin/orders.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/orders.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <script type="module">
                    ConvertTimestamp.init("timestamp");
                </script>
                <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2">
                    <caption class="caption-top text-right p-1 sm:p-4">
                        <x-admin.orders-filter :filter="$filter" />
                    </caption>
                    <caption class="caption-bottom text-right p-4">
                        {{ $orders->onEachSide(1)->links() }}
                    </caption>
                    <thead>
                    <tr class="text-gray-500">
                        <td class="p-2">{{ __('admin/orders.list.order') }}</td>
                        <td class="p-2 hidden sm:table-cell">{{ __('admin/orders.list.login') }}</td>
                        <td class="p-2 hidden sm:table-cell">{{ __('admin/orders.list.status') }}</td>
                        <td class="p-2 text-right"> </td>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 flex justify-start items-center gap-4">
                            <div class="h-min">{{ $order['id'] }} <span class="timestamp text-sm text-gray-500">{{ $order['created_at'] }}</span>
                                <div class="block sm:hidden text-sm text-gray-500">
                                    <div>{{ __('admin/orders.list.login') }}: {{ $order['login'] }} / ID: {{ $order['user_id'] }}</div>
                                    <div>{{ __('admin/orders.list.status') }}: {{ $siteSettings['order_status'][$order['status']] ?? '' }}
                                            (<span class="timestamp">{{ $order['updated_at'] }}</span>)</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 hidden sm:table-cell">{{ $order['login'] }}
                            <span class="text-sm text-gray-500">ID: {{ $order['user_id'] }}</span>
                        </td>
                        <td class="p-2 hidden sm:table-cell">{{ $siteSettings['order_status'][$order['status']] ?? '' }}
                            <span class="timestamp text-sm text-gray-500">{{ $order['updated_at'] }}</span></td>
                        <td class="p-2 sm:text-right">
                            <a class="font-medium text-indigo-600 hover:text-indigo-500"
                               href="{{ route('admin.orders.order', ['id' => $order['id']]) }}">{{ __('admin/orders.list.view') }}</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
