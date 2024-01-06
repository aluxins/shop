@props(['product'])
<!-- Product info -->
<div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $product['name'] }}</h1>
    </div>

    <!-- Options -->
    <div class="mt-4 lg:row-span-3 lg:mt-0">
        <h2 class="sr-only">Product information</h2>
        <p class="text-3xl tracking-tight {{ $product['old_price'] > $product['price'] ? 'text-red-500' : 'text-gray-900'}} after:content-['{{ __('currency-icon') }}']">{{ $product['price'] }}</p>
        @if($product['old_price'] > $product['price'])
            <span class="text-xs font-medium text-gray-900 align-top line-through">{{ $product['old_price'] }}</span>
        @endif
        <form class="cart flex flex-nowrap gap-x-1">
            <input name="product" type="hidden" value="{{ $product['id'] }}" />
            <label>
                <input type="number" class="form-input w-16 rounded-2xl active:scale-110 active:bg-yellow-700 duration-0"
                       value="{{ $product['available'] < 1 ? 0 : 1 }}" name="quantity" min="0" max="{{ $product['available'] }}"
                       data-add="bg-yellow-500" />
            </label>
            <button class="relative rounded-2xl shadow-lg text-white bg-yellow-500 hover:bg-yellow-600 hover:shadow-xl w-full active:scale-110 active:bg-yellow-700 duration-0">
                В корзину
            </button>
        </form>
    </div>

    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
        <!-- Description and details -->
        <p class="mt-1 text-sm text-gray-500">Арт. {{ $product['article'] }}</p>
        <div>
            <h3 class="sr-only">Description</h3>

            <div class="space-y-6">
                <p class="text-base text-gray-900">{{ $product['description'] }}</p>
            </div>
        </div>
    </div>
</div>
