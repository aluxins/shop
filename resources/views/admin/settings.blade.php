<x-app-layout>

    <x-slot name="title">
        {{ __('admin/settings.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/settings.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-admin.settings-form :settings="$settings" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
