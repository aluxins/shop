<x-app-layout>

    <x-slot name="title">
        {{ __('admin/index.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/index.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                Admin panel
            </div>
        </div>
    </div>
</x-app-layout>
