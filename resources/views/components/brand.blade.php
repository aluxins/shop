@props(['activeBrands'])
@if(count($brands) > 0)
    <div x-data="{ open: window.innerWidth >= 1024 ? true : false }"
         @resize.window="open = window.innerWidth >= 1024 ? true : false"
         class="w-full p-2 bg-white rounded-lg shadow block mb-4">
        <form method="post" action="{{ route('catalog.filter', ['id' => request()->route('id')]) }}">
            @csrf
        <div class="text-sm font-medium text-gray-900 flex flex-row justify-between">
            <div @click="open = true" class="cursor-pointer lg:cursor-default px-2 py-1 lg:py-3 grow hover:bg-gray-100 lg:hover:bg-white rounded-2xl">
                {{ __('brand.name') }}
                @if(count($activeBrands) > 0)
                    <span class="text-sm text-gray-500"> ({{ __('brand.selected') }} {{ count($activeBrands) }})</span>
                @endif
                <div class="text-sm text-gray-500 inline-block lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div x-show="open" @click="open = false" class="cursor-pointer text-gray-500 block lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
            <div x-show="open" x-transition>
                <ul class="space-y-2 text-sm mt-3 lg:mt-0 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-2 overscroll-y-contain overflow-y-scroll sm:max-h-52"
                    aria-labelledby="dropdownDefault">
                    @foreach($brands as $brand)
                    <li class="flex items-center py-1">
                        <label class="ml-2 text-sm font-medium text-gray-900">
                        <input class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                               name="brands[{{ $brand['id'] }}]" type="checkbox" value="{{ $brand['id'] }}"
                               {{ in_array($brand['id'], $activeBrands) ? 'checked' : '' }}>
                            {{ $brand['name'] }}
                        </label>
                    </li>
                    @endforeach
                </ul>
                <div class="mt-3 text-center flex flex-row gap-6 justify-between">
                    <button class="rounded-2xl border border-transparent bg-yellow-500 w-1/2 text-sm text-white shadow-sm hover:bg-yellow-600">
                        {{ __('brand.apply') }}
                    </button>
                    <a class="rounded-2xl border w-1/3 text-sm text-gray-600 shadow-sm hover:bg-gray-100 hover:text-gray-800"
                        href="{{ route('catalog', ['id' => request()->route('id')]) }}">
                        {{ __('brand.reset') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endif
