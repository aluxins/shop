<div class="flex flex-row justify-between p-2">
    <!-- Logo -->
    <div class="shrink-0 flex items-center font-semibold text-xl text-gray-800 dark:text-gray-200">
        <a href="{{ route('index') }}" class="mx-2">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
        <a href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }}
        </a>
    </div>

    <div class="ml-4 grow mr-4">
        <!-- Search -->
        <label for="search">
        </label>
        <form class="relative m-auto text-end" method="get" action="{{ route('search') }}">
            <input class="border rounded-2xl py-1 pl-2 pr-8 min-w-24 w-1/2 sm:w-1/3 focus:w-full focus:shadow-xl active:border-gray-200 duration-200"
                   type="" name="search" id="search" placeholder="{{ __('navigation.search') }}" autocomplete="off" maxlength="100" />
            <div class="absolute p-1 inset-y-0 right-0">
                <button class="text-gray-500 active:scale-110 active:text-gray-800 duration-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="text-right self-center font-light hidden sm:block">
        <span>{{ cache('siteSettings')['header_contacts'] }}</span>
    </div>
</div>
<div class="flex flex-row items-center pl-1 justify-between">
    <x-menu.index idStart="{{$id ?? 0}}" type="menu" :open="$open" />

    <div class="text-center grow font-light block sm:hidden">
        <span>{{ cache('siteSettings')['header_contacts'] }}</span>
    </div>

    <div class="flex flex-row justify-end">
        @include('layouts.navigation')
    </div>
</div>
