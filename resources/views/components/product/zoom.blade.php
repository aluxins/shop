@props(['name'])
<div>
    <div x-show="open" x-cloak
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity z-20"></div>
    <div x-show="open" x-cloak
        @keydown.window.escape="open = false"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed flex items-center justify-center max-h-full inset-0 mx-4 sm:mx-8 z-20">
            <div @click.away="open = false"
                 class="relative self-center object-scale-down p-4 max-h-screen drop-shadow-md rounded-md m-auto transform overflow-hidden bg-white text-left shadow-xl transition-all">
                <div class="flex items-center justify-between content-center">
                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">{{ $name }}</h2>
                    <div class="ml-3 flex h-7 items-center">
                        <button type="button" class="relative -m-2 p-2 text-gray-400 hover:text-gray-500" @click="open = false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <img class="relative rounded-md cursor-zoom-out max-h-screen" alt="Закрыть" @click="open = false" :src="imageUrlFull" />
            </div>
    </div>
</div>
