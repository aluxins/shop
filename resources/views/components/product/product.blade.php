@php
    if(!empty($product['images'])){
        // Сортируем массив изображений
        $product['images'] = sortImages($product['images']);
    }
    else $product['images'] = [config('image.defaultSrc') => 0];
@endphp
<div class="bg-white">
    <div class="pt-6">

        @foreach($product['images'] as $image_src => $sort)

            @if ($loop->first)
                <!-- Image gallery -->
                <div class="flex flex-col lg:flex-row gap-6 justify-between mx-auto lg:h-96"
                     x-data="{imageUrl: '{{ Storage::url(
                                config('image.folder')).config('image.modification.fit.prefix').$image_src }}',
                              imageUrlFull: '{{ Storage::url(
                                config('image.folder')).config('image.modification.original.prefix').$image_src }}'}">

                    <!-- Image main -->
                    <div x-data="{ open: false }" class="lg:grid h-3/4 lg:h-full lg:w-3/4">
                        <div>
                            <img class="h-auto w-auto min-w-28 mx-auto object-cover object-center rounded cursor-pointer"
                                 @click="open = ! open"
                                 :src="imageUrl"
                                 alt="{{ $product['name'] }}">
                        </div>

                        <!-- Image zoom -->
                        <x-product.zoom :name="$product['name']" />
                        <!-- / Image zoom -->
                    </div>
                    <!-- / Image main -->

                    <!-- Image items -->
                    <div class="flex flex-row lg:flex-col gap-6 h-1/4 lg:h-full w-full lg:w-1/4 overflow-x-auto lg:overflow-y-auto px-0 lg:px-3 py-3 lg:py-0">

            @endif
                        @if($loop->count > 1)
                        <!-- Item {{ $loop->iteration }} -->
                        <div class="w-full ml-auto">
                            <img class="h-auto w-auto min-w-28 mx-auto object-cover object-center rounded cursor-pointer"
                                     src="{{ Storage::url(
                                            config('image.folder')).config('image.modification.fit.prefix').$image_src }}"
                                     @click="imageUrl = '{{ Storage::url(
                                            config('image.folder')).config('image.modification.fit.prefix').$image_src }}';
                                            imageUrlFull = '{{ Storage::url(
                                            config('image.folder')).config('image.modification.original.prefix').$image_src }}'"
                                 alt="{{ $product['name'] }}">
                        </div>
                        @endif

            @if ($loop->last)
                    </div>
                    <!-- / Image items -->
                </div>
                <!-- / Image gallery -->
            @endif

            @endforeach

        <x-product.info
            :product="$product"
        />
    </div>
</div>
