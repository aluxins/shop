@props(['product'])
@php
//Определяем главное изображение
$image_src = "";
if(!empty($product['images'])){
    $image_sort = 128;
    foreach(json_decode($product['images']) as $name => $sort)
        {
            if($sort <= $image_sort){
                $image_src = $name;
                $image_sort = $sort;
            }
        }
}
else $image_src = "default.jpg";
@endphp
            <div class="group relative">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75">
                    <img src="{{Storage::url(
                            config('image.folder').config('image.modification.fit.prefix').$image_src
                                )}}" alt="{{ $product['name'] }}"
                         class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                </div>

                    <div>
                        <h3 class="text-sm text-gray-700">
                            <a href="#">
                                {{-- <span aria-hidden="true" class="absolute inset-0"></span> --}}
                                {{ $product['name'] }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Арт. {{ $product['article'] }}</p>
                    </div>
                <div class="mt-4 flex justify-between">
                    <div class="text-sm font-medium {{ $product['old_price'] > $product['price'] ? 'text-red-500' : 'text-gray-900'}}">
                        {{ $product['price'] }} &#8381;
                        @if($product['old_price'] > $product['price'])
                            <span class="text-xs font-medium text-gray-900 align-top line-through">{{ $product['old_price'] }}</span>
                        @endif
                    </div>
                    <button>В корзину
                    </button>
                </div>
            </div>


