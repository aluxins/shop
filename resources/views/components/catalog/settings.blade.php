<div class="flex items-baseline justify-end gap-4 my-1 mx-3 lg:mx-0">
    @foreach(config('app.store_settings')['catalog'] as $key => $val)
        <div x-data="{ open: false }" class="relative">
            <div>
                <button @click="open = !open" type="button" class="group inline-flex justify-center text-sm font-light text-gray-700 hover:text-gray-900" id="menu-button" aria-expanded="false" aria-haspopup="true">
                    {{ __('catalog.settings.'.$key) }}
                    <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div x-show="open"
                 x-cloak
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    @foreach($val['values'] as $value)
                        <a href="{{ request()->fullUrlWithQuery(['settings' => $key .'_'. $value]) }}"
                           class="{{ session()->get('catalog_settings')[$key] == $value ? 'font-medium text-gray-900' : 'text-gray-500' }}text-gray-500 hover:bg-gray-50 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1">
                            {{ trans()->has('catalog.settings.'.$value) ? __('catalog.settings.'.$value) : $value }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
  @endforeach
</div>
