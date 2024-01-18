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
                            <img src="{{Storage::url(config('image.folder')).config('image.modification.fit.prefix').$image_src}}"
                                 alt="{{ $product['name'] }}"
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
                <div class="mt-4 flex justify-between flex-nowrap">
                    <div class="text-lg lg:text-sm font-medium {{ $product['old_price'] > $product['price'] ? 'text-red-500' : 'text-gray-900'}}">
                        <span class="text-nowrap after:content-['{{ __('currency-icon') }}']">{{ $product['price'] }}</span>
                        @if($product['old_price'] > $product['price'])
                            <span class="text-xs font-medium text-gray-900 align-top line-through">{{ $product['old_price'] }}</span>
                        @endif
                    </div>
                    <form class="cart flex flex-nowrap gap-x-1">
                        <input name="product" type="hidden" value="{{ $product['id'] }}" />
                        <label class="flex flex-row h-10">
                            <input type="number" class="form-input border border-r-0 border-yellow-500 rounded-l-2xl w-16 m-0 active:scale-110 duration-0"
                                   value="{{ $product['available'] < 1 ? 0 : 1 }}" name="quantity" min="0" max="{{ $product['available'] }}"
                                   data-add="bg-yellow-500" autocomplete="off" />

                        <button class="rounded-r-2xl  text-white bg-yellow-500 hover:bg-yellow-600 hover:shadow-xl w-10 h-10   active:scale-110 active:bg-yellow-700 duration-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 26 26" stroke-width="1.5" stroke="currentColor" class="m-auto w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                            </svg>
                        </button>
                        </label>
                    </form>
                </div>
            </div>


