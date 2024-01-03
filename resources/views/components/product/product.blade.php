@php
    if(!empty($product['images'])){
        // Сортируем массив изображений
        $product['images'] = json_decode($product['images'], true);
        uasort($product['images'], function ($a, $b) {
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            }
        );
    }
    else $product['images'] = [config('image.defaultSrc') => 0];
@endphp
<div class="bg-white">
    <div class="pt-6">

        @foreach($product['images'] as $image_src => $sort)

            @if ($loop->first)
                <!-- / Image gallery -->
                <div class="lg:flex lg:flex-row lg:gap-6 lg:justify-center mx-auto lg:h-[calc({{config('image.modification.fit.resize')}}px)]"
                     x-data="{imageUrl: '{{ Storage::url(
                                config('image.folder')).config('image.modification.fit.prefix').$image_src }}',
                              imageUrlFull: '{{ Storage::url(
                                config('image.folder')).config('image.modification.original.prefix').$image_src }}'}">

                <div x-data="{ open: false }">
            @endif

                <div class="{{ $loop->first ? 'w-full lg:basis-3/4' : 'w-full ml-auto' }}">
                    <img class="h-full w-full object-cover object-center rounded cursor-pointer"
                         @if ($loop->first)
                             @click="open = ! open"
                             :src="imageUrl"
                         @else
                             src="{{ Storage::url(
                                    config('image.folder')).config('image.modification.fit.prefix').$image_src }}"
                             @click="imageUrl = '{{ Storage::url(
                                    config('image.folder')).config('image.modification.fit.prefix').$image_src }}';
                                    imageUrlFull = '{{ Storage::url(
                                    config('image.folder')).config('image.modification.original.prefix').$image_src }}'"
                         @endif
                         alt="{{ $product['name'] }}">
                </div>

                @if ($loop->first)
                    <x-product.zoom
                        :name="$product['name']"
                    />
                </div>
                    <div class="hidden lg:flex lg:flex-col lg:gap-6 lg:basis-1/4 lg:overflow-y-auto px-3">
                @endif

                @if ($loop->last)
                    </div>
                </div>
                <!-- Image gallery / -->
                @endif

            @endforeach

        <x-product.info
            :name="$product['name']"
            :article="$product['article']"
            :description="$product['description']"
            :price="$product['price']"
            :old_price="$product['old_price']"
        />
    </div>
</div>
