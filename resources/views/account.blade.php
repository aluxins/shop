<x-app-layout>

    <x-slot name="title">
        {{ __("account.title") }}
    </x-slot>

    <x-slot name="heading">
        {{ __("account.title") }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <script type="module">
        ConvertTimestamp.init("timestamp", "date");
    </script>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('status') === 'success-auth')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-lg text-center text-green-600 py-2"
                    >{{ __('account.success-auth') }}</p>
                @endif
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between p-2 gap-6">
                        <div class="md:basis-1/2 border  rounded-xl">
                            <div class="font-medium bg-gray-100 rounded-t-xl py-4 px-2 text-gray-900">{{ __("account.active") }}</div>

                            @forelse($orders as $order)
                            <div class="flex gap-2 p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800 text-clip overflow-hidden">
                                <span class="flex-none"># {{ $order['id'] }}</span>
                                <span class="flex-none">{{ $siteSettings['order_status'][$order['status']] ?? '' }}</span>
                                <span class="timestamp flex-none text-xs text-gray-400 pt-1">{{ $order['updated_at'] }}</span>
                                <span class="grow text-right">
                                    <a class="text-indigo-600 hover:text-indigo-500" href="{{ route('order.index', ['id' => $order['id']]) }}">
                                        <span class="hidden sm:inline">{{ __('account.view') }}</span>
                                        <span class="inline sm:hidden">→</span>
                                    </a>
                                </span>
                            </div>
                            @empty
                                <div class="p-2 m-1 text-center">
                                    {{ __("account.noActive") }}
                                </div>
                            @endforelse
                            <div class="p-2 m-1 text-right"><a class="text-indigo-600 hover:text-indigo-500" href="{{ route('order.index') }}">{{ __('account.all') }}</a></div>
                        </div>

                        <div class="sm:basis-1/2 border  rounded-xl">
                            <div class="font-medium bg-gray-100 rounded-t-xl py-4 px-2 text-gray-900">{{ __("account.personal") }}</div>

                            <div class="flex-col gap-2 p-2 m-1 hover:bg-gray-50 rounded-xl text-gray-800">
                                <div class="font-semibold">{{ __('account.fullName') }}:
                                    <span class="font-normal">
                                    {{ $information['first_name'] ?? '' }} {{ $information['last_name'] ?? '' }} {{ $information['patronymic'] ?? '' }}
                                    </span>
                                </div>
                                <div class="font-semibold">{{ __('account.city') }}: <span class="font-normal">{{ $information['city'] ?? '' }}</span></div>
                                <div class="font-semibold">{{ __('account.street') }}: <span class="font-normal">{{ $information['street_address'] ?? '' }}</span></div>
                                <div class="font-semibold">{{ __('account.telephone') }}: <span class="font-normal">{{ $information['telephone'] ?? '' }}</span></div>
                                <div class="font-semibold">{{ __('account.about') }}: <span class="font-normal">{{ $information['about'] ?? '' }}</span></div>
                                <div class=" text-right"><a class="text-indigo-600 hover:text-indigo-500" href="{{ route('profile.edit') }}">{{ __('account.edit') }}</a></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
