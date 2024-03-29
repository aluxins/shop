<x-app-layout>

    <x-slot name="title">
        {{ $page['name'] }}
    </x-slot>

    <x-slot name="heading">
        {{ $page['title'] }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {!! $page['body'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
