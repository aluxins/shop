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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ url()->previous() }}">BACK</a>
                <pre>
                {{ var_dump($order) }}
                </pre>
            </div>
        </div>
    </div>
</x-app-layout>
