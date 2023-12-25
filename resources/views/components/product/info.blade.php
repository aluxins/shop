@props(['name', 'article', 'description', 'price', 'old_price'])
<!-- Product info -->
<div class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $name }}</h1>
    </div>

    <!-- Options -->
    <div class="mt-4 lg:row-span-3 lg:mt-0">
        <h2 class="sr-only">Product information</h2>
        <p class="text-3xl tracking-tight {{ $old_price > $price ? 'text-red-500' : 'text-gray-900'}}">
            {{ $price }} &#8381;
        </p>
        @if($old_price > $price)
            <span class="text-xs font-medium text-gray-900 align-top line-through">{{ $old_price }}</span>
        @endif
        <form class="mt-10">
            <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Добавить в корзину
            </button>
        </form>
    </div>

    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
        <!-- Description and details -->
        <p class="mt-1 text-sm text-gray-500">Арт. {{ $article }}</p>
        <div>
            <h3 class="sr-only">Description</h3>

            <div class="space-y-6">
                <p class="text-base text-gray-900">{{ $description }}</p>
            </div>
        </div>
    </div>
</div>
