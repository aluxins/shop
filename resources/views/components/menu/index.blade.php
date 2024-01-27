@switch($type)
    @case('menu')
        {{-- https://codepen.io/martinridgway/pen/KVdKQJ --}}
        <div x-data="{ open: false }" id="dropdown-menu"
             @keydown.window.escape="open = false">
            <div class="cd-dropdown-wrapper z-20">
                <div x-show="open" x-cloak
                     x-transition:enter="ease-in-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>

                {{-- cd-index-close скрывает кнопку меню на главной странице --}}
                <button @click="open = ! open" class="group flex items-center h-full pl-3 pr-2 text-base lg:text-lg font-light rounded-lg
                            bg-slate-600 text-gray-100">
                    <span class="">{{ __('navigation.menu.name') }}</span>
                    <svg class="pl-1 mt-0.5 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-white group-focus:text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                {{-- cd-index-open отображает меню на главной странице --}}

                <nav x-show="open" x-cloak
                     @click.away="open = false"
                     x-on:mouseenter="if(typeof timeout !== 'undefined') clearInterval(timeout)"
                     x-on:mouseleave="width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                                if (width > 1024) { if(typeof timeout !== 'undefined') clearInterval(timeout)
                                timeout = setTimeout(() => { open = false }, 300) }"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="-translate-x-full sm:opacity-0"
                     x-transition:enter-end="translate-x-0 sm:opacity-100"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0 sm:opacity-100"
                     x-transition:leave-end="-translate-x-full sm:opacity-0"
                     class="cd-dropdown w-screen max-w-md lg:rounded-l-xl">
                    <h2>{{ __('navigation.menu.name') }}</h2>
                    <a @click="open = false" class="cd-close cursor-pointer flex justify-center">
                        <svg class="h-6 w-6 text-gray-500 self-center" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                    <ul class="cd-dropdown-content">
                        {{-- Поле поиска
                        <li>
                            <form class="cd-search">
                                <input type="search" placeholder="Search...">
                            </form>
                        </li>
                        --}}
                        {{-- @php $i = 0 @endphp --}}
                             @foreach($arraySections as $el)
                                 <x-menu.children-1
                                     :id="$el['id']"
                                     :name="$el['name']"
                                     :link="$el['link']"
                                     :children="$el['children']"
                                     base="{{route('catalog')}}"
                                 />
                             {{-- @php $i++; @endphp --}}
                        @endforeach
                    {{--
                    @section('menuCount')
                        @for($k = 0; $k < $i; $k++)
                        <div class="pt-[50px] hidden lg:block"></div>
                        @endfor
                    @endsection
                    --}}
                    </ul>
                </nav>
            </div>
        </div>

        @break;

    @case('tree')
        <div class="text-gray-300 text-sm">
            @if(count($arrayTree) > 0)
                <a class="text-gray-500 font-medium" href="{{ route('catalog') }}">
                    {{ __('navigation.menu.home') }}
                </a>
            @endif
            @php
                krsort($arrayTree);
            @endphp
            @foreach($arrayTree as $el)
                / <a class="text-gray-500 font-medium"  href="{{ route('catalog', ['id' => $el['id']]) }}">
                    {{ $el['name'] }}
                </a>
            @endforeach
        </div>
        @section("nameSection", $el['name'] ?? __('navigation.menu.home'))
        @break;

    @case('select')
        @foreach($arraySections as $el)
                 <x-menu.option
                    :id="$el['id']"
                    :name="$el['name']"
                    :link="$el['link']"
                    :children="$el['children']"
                    :selected="$selected"
                    i="0"
                />
        @endforeach
        @break;

@endswitch


