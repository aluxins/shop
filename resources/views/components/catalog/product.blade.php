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
else $image_src = config('image.defaultSrc');
@endphp
            <div class="group flex flex-col place-content-between h-auto rounded-md hover:bg-gray-50 hover:shadow-xl p-2">
                <div>
                    <div class="w-full overflow-hidden rounded-md group-hover:opacity-75">
                        <a href="{{ route('product', ['id' => $product['id']]) }}">
                            <img src="{{Storage::url( config('image.folder').config('image.modification.fit.prefix').$image_src
                                        )}}" alt="{{ $product['name'] }}"
                                 class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        </a>
                    </div>

                    <div>
                        <h3 class="text-sm text-gray-700">
                            <a href="{{ route('product', ['id' => $product['id']]) }}">
                                {{-- <span aria-hidden="true" class="absolute inset-0"></span> --}}
                                {{ $product['name'] }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">Арт. {{ $product['article'] }}</p>
                    </div>
                </div>
                <div class="mt-4 flex justify-between">
                    <div class="text-sm font-medium {{ $product['old_price'] > $product['price'] ? 'text-red-500' : 'text-gray-900'}}">
                        {{ $product['price'] }} &#8381;
                        @if($product['old_price'] > $product['price'])
                            <span class="text-xs font-medium text-gray-900 align-top line-through">{{ $product['old_price'] }}</span>
                        @endif
                    </div>
                    <form class="cart">
                        <input name="product" type="hidden" value="{{ $product['id'] }}" />
                        <input name="quantity" type="hidden" value="1" />
                        <button class="rounded-2xl shadow-lg p-2 text-white bg-yellow-500 hover:bg-yellow-600 hover:shadow-xl"
                            >В&#160;корзину</button>
                    </form>
                </div>
            </div>


