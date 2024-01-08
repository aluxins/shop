<x-app-layout>

    <x-slot name="title">
        Оформление заказа
    </x-slot>

    <x-slot name="heading">
        Оформление заказа
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="p-6 grid grid-cols-1 gap-x-16 sm:grid-cols-2">
                        <div class="">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-base font-semibold leading-7 text-gray-900">Order summary</h3>
                                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">The order price including discounts.</p>
                            </div>
                            <div class="mt-6 border-t border-gray-100">
                                <dl class="divide-y divide-gray-100">
                                    <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Subtotal</dt>
                                        <dd class="mt-1 text-sm text-right leading-6 text-gray-700 sm:col-span-2 sm:mt-0 after:content-['{{ __('currency-icon') }}']">{{ number_format($order['full'], 2) }}</dd>
                                    </div>
                                    <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Discount</dt>
                                        <dd class="mt-1 text-sm text-right leading-6 text-gray-700 sm:col-span-2 sm:mt-0 after:content-['{{ __('currency-icon') }}']">{{ number_format($order['sale'], 2) }}</dd>
                                    </div>
                                    <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Order total</dt>
                                        <dd class="mt-1 text-sm text-right leading-6 font-semibold text-indigo-600 sm:col-span-2 sm:mt-0 after:content-['{{ __('currency-icon') }}']">{{ number_format($order['total'], 2) }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="px-4 sm:px-0">
                                <form action="{{ route('order.store') }}" method="post">
                                    @csrf
                                    <button class="rounded-2xl border border-transparent bg-yellow-500 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-yellow-600 w-full">Оформить</button>
                                </form>
                            </div>
                        </div>
                        <div class="border p-4 my-6 sm:my-0 rounded-2xl">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-base font-semibold leading-7 text-gray-900">Applicant Information</h3>
                                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Personal details and application.</p>
                            </div>
                            <div class="mt-6 border-t border-gray-100">
                                <dl class="divide-y divide-gray-100">
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $information['first_name'] }} {{ $information['last_name'] }} {{ $information['patronymic'] }}</dd>
                                    </div>
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Telephone</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $information['telephone'] }}</dd>
                                    </div>
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">City</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $information['city'] }}</dd>
                                    </div>
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Street address</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $information['street_address'] }}</dd>
                                    </div>
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">Email address</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $user->email }}</dd>
                                    </div>
                                    <div class="p-2 md:grid md:grid-cols-3 md:gap-4 md:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">About</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 md:col-span-2 md:mt-0">{{ $information['about'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="px-4 sm:px-0 text-right">
                                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('profile.edit') }}">edit<span aria-hidden="true"> →</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
