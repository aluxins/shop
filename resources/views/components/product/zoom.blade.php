@props(['name'])
<div x-show="open" @keydown.window.escape="open = false"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen">
        <div class="flex h-screen p-8 items-center justify-center text-center">
            <div class="relative object-scale-down max-h-full p-4 drop-shadow-md rounded-md m-auto transform overflow-hidden bg-white text-left shadow-xl transition-all" @click.away="open = false">
                <div class="flex items-start justify-between">
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
                <img class="rounded-md cursor-zoom-out" alt="Закрыть" @click="open = false" :src="imageUrlFull" />
            </div>
        </div>
    </div>
</div>
