<x-app-layout>

    <x-slot name="title">
        @yield('title')
    </x-slot>
    {{--
        <x-slot name="heading">
            {{ $page['name'] }}
        </x-slot>
    --}}
    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section>
                            <div class="flex items-center">
                                <div class="justify-center max-w-6xl px-2 mx-auto text-center w-full sm:w-3/4">
                                    <div class="rounded-2xl w-full p-4 bg-white lg:p-16">
                                        <h1 class="inline-block mb-8 font-bold text-gray-700 text-3xl lg:text-3xl">
                                            @yield('code')
                                        </h1>
                                        <h2 class="mb-6 text-2xl font-semibold text-gray-600 lg:text-3xl">
                                            @yield('message')
                                        </h2>
                                        <p class="mb-8 text-xs text-gray-600 lg:text-xl">
                                            {{--
                                            Sorry! The requested page not found.You might try a search below...
                                            --}}
                                        </p>

                                        <form class="mb-8" method="get" action="{{ route('search') }}">
                                            <div class="flex px-6 py-2 my-4 border-gray-700 rounded-2xl bg-center bg-no-repeat bg-cover bg-gradient-to-r from-gray-200 to-gray-50 ">
                                                <label class="w-full ">
                                                    <input type="text"
                                                           name="search"
                                                           class="w-full pr-4 rounded-2xl text-sm text-gray-700 bg-white placeholder-text-100 "
                                                           placeholder="{{ __('navigation.search') }}" autocomplete="off">
                                                </label>
                                                <button class="ml-2 text-gray-500 active:scale-110 active:text-gray-800 duration-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                        <div class="flex flex-wrap items-center justify-center">
                                            <a href="{{ route('index') }}"
                                               class="px-4 py-4 text-md font-medium text-gray-700 uppercase rounded-full lg:text-base  md:w-auto bg-center bg-no-repeat bg-cover bg-gradient-to-r from-gray-200 to-gray-50 ">
                                                {{ __('errors.back') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
