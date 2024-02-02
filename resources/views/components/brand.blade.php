@props(['activeBrands'])
@if(count($brands) > 0)
    <div x-data="{ open: window.innerWidth >= 1024 ? true : false }"
         @resize.window="open = window.innerWidth >= 1024 ? true : false"
         class="w-full p-2 bg-white rounded-lg shadow block mb-4">
        <form method="post" action="{{ route('catalog.filter', ['id' => request()->route('id')]) }}">
            @csrf
        <div class="text-sm font-medium text-gray-900 flex flex-row justify-start">
            <div @click="open = true" class="cursor-pointer lg:cursor-default px-2 py-1 lg:py-3 group inline-flex justify-start grow gap-1 hover:bg-gray-100 lg:hover:bg-white rounded-2xl">
                {{ __('brand.name') }}
                @if(count($activeBrands) > 0)
                    <span class="text-sm text-gray-500 font-light"> ({{ __('brand.selected') }} {{ count($activeBrands) }})</span>
                @endif
                <div class="text-sm text-gray-500 inline-block lg:hidden">
                    <svg class="ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div x-show="open" x-cloak @click="open = false" class="cursor-pointer text-gray-500 block lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
            <div x-show="open" x-cloak x-transition>
                <ul class="space-y-2 text-sm mt-3 lg:mt-0 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-1 gap-2 overscroll-y-contain overflow-y-scroll sm:max-h-52"
                    aria-labelledby="dropdownDefault">
                    @foreach($brands as $brand)
                    <li class="flex items-center py-1">
                        <label class="ml-2 text-sm font-medium text-gray-900">
                        <input class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                               name="brands[{{ $brand['id'] }}]" type="checkbox" value="{{ $brand['id'] }}"
                               {{ in_array($brand['id'], $activeBrands) ? 'checked' : '' }}>
                            {{ $brand['name'] }}
                            <span class="text-md text-gray-500 font-light"> {{ $brand['count'] }} </span>
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
