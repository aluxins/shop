@props(['name', 'url', 'method'])
<div x-data="{ open: false }" @keydown.window.escape="open = false" class="inline-block">
    <button @click="open = true" class="ml-auto mr-0 p-1 rounded-lg text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100">
        {{ $name }}
    </button>
    <div x-show="open" x-cloak
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity">
    </div>
    <div x-show="open" x-cloak
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.outside="open = false"
         class="bg-white rounded-2xl shadow-xl fixed inset-0 m-auto max-h-32 max-w-96 overflow-hidden">
        <div class="flex flex-col h-full">
            <div class="grow text-center text-md pt-4">
                <h3 class="text-lg">{{ __('admin/confirm.header') }}</h3>
                {{ $slot }}
            </div>
            <div class="flex flex-row justify-between mx-4 my-2">
                <button @click="open = false" class="border p-1 rounded-lg text-sm text-gray-800  hover:bg-gray-100 w-1/3">
                    {{ __('admin/confirm.close') }}
                </button>
                <form class="w-1/3" method="post" action="{{ $url }}">
                    @csrf
                    @if($method == 'delete')
                    @method('DELETE')
                    @endif
                    <button class="border border-red-500 p-1 rounded-lg text-sm text-white bg-red-500 hover:bg-red-600 w-full">
                        {{ __('admin/confirm.confirm') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
