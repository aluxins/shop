<x-app-layout>

    <x-slot name="title">
        {{ __('admin/sections.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('admin/sections.title') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-admin.tree
                        :tree="$tree"
                        route="admin.sections.index" />
                    <x-admin.table-form
                        method="PATCH"
                        thead=";#;{{ __('admin/sections.thead') }}"
                        :tbody="$list"
                        :id="$id" />
            </div>
        </div>
    </div>
</div>
</x-app-layout>
