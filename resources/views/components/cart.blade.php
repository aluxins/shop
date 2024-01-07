<script type="module">
    Cart.init("cart");
</script>
<div x-data="{ open: false }" class="cart-button inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out">
    <button @click="open = !open" class="relative w-10 h-10">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="p-1 w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </svg>
        <span class="absolute text-red-500 top-0 right-0 text-sm"></span>
    </button>
    <div  @keydown.window.escape="open = false" x-show="open" class="relative z-10" aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

        <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>


        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                    <div x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md" x-description="Slide-over panel, show/hide based on slide-over state." @click.away="open = false">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">Корзина товаров</h2>
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

                                <h1 class="hidden text-2xl font-light text-center text-gray-900 mt-6" id="slide-over-title">Корзина пуста</h1>

                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                                            <li class="py-6">
                                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                    <img src="{{Storage::url('/public/loading-thumb.gif')}}" alt="Загрузка" class="h-full w-full object-cover object-center">
                                                </div>

                                                <div class="hidden ml-4 flex flex-1 flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3>
                                                                <a href="#"><!-- Name --></a>
                                                            </h3>
                                                            <div>
                                                            <p class="ml-4 whitespace-nowrap after:content-['{{ __('currency-icon') }}']"><!-- Price --></p>
                                                            <p class="ml-4 whitespace-nowrap text-xs font-medium text-gray-900 align-top line-through after:content-['{{ __('currency-icon') }}']"><!-- Old Price --></p>
                                                            </div>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500"><!-- Article --></p>
                                                    </div>
                                                    <div class="flex flex-1 items-end justify-between text-sm">
                                                        <p class="text-gray-500">
                                                            <label>
                                                                <!-- Quantity -->
                                                                <input type="number" class="form-input w-20 rounded-2xl" value="" name="quantity" min="1" max="999" />
                                                            </label>
                                                        </p>

                                                        <div class="flex">
                                                            <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Удалить</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="cart-order border-t border-gray-200 px-4 py-6 sm:px-6">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Итого</p>
                                    <p class="full whitespace-nowrap line-through after:content-['{{ __('currency-icon') }}']"></p>
                                </div>
                                <div class="flex justify-between text-sm font-medium text-red-500">
                                    <p>Скидка</p>
                                    <p class="sale whitespace-nowrap after:content-['{{ __('currency-icon') }}']"></p>
                                </div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>К оплате</p>
                                    <p class="total whitespace-nowrap after:content-['{{ __('currency-icon') }}']"></p>
                                </div>
                                <p class="mt-0.5 text-sm text-gray-500">Доставка рассчитывается после оформления заказа.</p>
                                <div class="mt-6">
                                    <a href="{{ route('order.create') }}" class="flex items-center justify-center rounded-2xl border border-transparent bg-yellow-500
                                        px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-yellow-600">Оформить</a>
                                </div>
                                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                    <p>
                                        или
                                        <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500" @click="open = false">
                                            продолжить покупки
                                            <span aria-hidden="true"> →</span>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
