<x-app-layout>


    <header class="bg-white dark:bg-gray-800 shadow flex flex-row items-center p-5 justify-start">
        <x-menu.index idStart="0" type="menu" />
            <!-- Logo -->
            <div class="shrink-0 flex items-center font-semibold text-xl text-gray-800 dark:text-gray-200 mx-5">
                <a href="{{ route('dashboard') }}" class="mx-2">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
                {{ __('Dashboard') }}
            </div>


        <div class="grow flex flex-row justify-end">
            @include('layouts.navigation')

        </div>
    </header>

    <div class="flex flex-row mx-5">
        <div class="basis-72 hidden lg:block">
        </div>

        <div class="basis-auto">

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
