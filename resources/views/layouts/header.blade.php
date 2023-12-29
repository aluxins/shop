<x-menu.index idStart="{{$id ?? 0}}" type="menu" :open="$open" />
<!-- Logo -->
<div class="shrink-0 flex items-center font-semibold text-xl text-gray-800 dark:text-gray-200 lg:px-5">
    <a href="{{ route('dashboard') }}" class="mx-2">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </a>
    {{ config('app.name', 'Laravel') }}
</div>

<div class="grow flex flex-row justify-end">
    @include('layouts.navigation')

</div>
