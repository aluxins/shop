<div class="flex flex-row justify-between p-2">
    <!-- Logo -->
    <div class="shrink-0 flex items-center font-semibold text-xl text-gray-800 dark:text-gray-200">
        <a href="{{ route('index') }}" class="mx-2">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
        {{ config('app.name', 'Laravel') }}
    </div>
    <div class="text-right w-3/4 self-center">
        <span>{{ cache('siteSettings')['header_contacts'] }}</span>
    </div>
</div>
<div class="flex flex-row items-center pl-1 ">
    <x-menu.index idStart="{{$id ?? 0}}" type="menu" :open="$open" />

    <div class="ml-6 w-full">
        <!-- Search -->
        <label for="search">
        </label>
        <form class="relative m-auto text-end" method="post" action="{{ route('search') }}">
            @csrf
            <input class="border rounded-2xl py-1 pl-2 pr-8 min-w-24 w-1/4 focus:w-full focus:shadow-xl active:border-gray-200 duration-200"
                   type="" name="search" id="search" placeholder="Search" autocomplete="off" />
            <div class="absolute p-1 inset-y-0 right-0">
                <button class="text-gray-500 active:scale-110 active:text-gray-800 duration-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="grow flex flex-row justify-end">
        @include('layouts.navigation')
    </div>
</div>
