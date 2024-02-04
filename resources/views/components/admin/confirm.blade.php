@props(['name', 'url', 'method'])
<div x-data="{ open: false }" @keydown.window.escape="open = false" class="inline-block">
    <div @click="open = true" class="cursor-pointer ml-auto mr-0 p-1 rounded-lg text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
        {{ $name }}
    </div>
    <div x-show="open" x-cloak
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity z-20">
    </div>
    <div x-show="open" x-cloak
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.outside="open = false"
         class="bg-white rounded-2xl shadow-xl fixed inset-0 m-auto max-h-32 max-w-96 overflow-hidden z-20">
        <div class="flex flex-col h-full">

            <div class="absolute top-0 right-0 mt-2 mr-2 flex h-7 items-center">
                <div  class="cursor-pointer text-gray-400 hover:text-gray-500" @click="open = false">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>

            <div class="grow text-center text-md pt-4">
                <h3 class="text-lg">{{ __('admin/confirm.header') }}</h3>
                {{ $slot }}
            </div>
            <div class="flex flex-row justify-between mx-4 my-2 gap-4">
                <div @click="open = false" class="cursor-pointer border p-1 rounded-lg text-sm text-gray-800 text-center hover:bg-gray-100 w-1/3">
                    {{ __('admin/confirm.close') }}
                </div>
                @if($method == 'get')
                    <a class="border border-red-500 p-1 rounded-lg text-sm text-white bg-red-500 hover:bg-red-600 w-1/3"
                       href="{{ $url }}">
                        {{ __('admin/confirm.confirm') }}
                    </a>
                @else
                    <form class="w-1/3" method="post" action="{{ $url }}">
                        @csrf
                        @if($method == 'delete')
                        @method('DELETE')
                        @endif
                        <button class="border border-red-500 p-1 rounded-lg text-sm text-white bg-red-500 hover:bg-red-600 w-full">
                            {{ __('admin/confirm.confirm') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
