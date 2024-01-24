@switch($type)
    @case('menu')
        {{-- https://codepen.io/martinridgway/pen/KVdKQJ --}}
        <div x-data="{ open: false }"
             @keydown.window.escape="open = false"
             x-on:mouseenter="if(typeof timeout !== 'undefined') clearInterval(timeout)"
             x-on:mouseleave="width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                                if (width > 1024) { timeout = setTimeout(() => { open = false }, 500) }"
             id="dropdown-menu">
            <div class="cd-dropdown-wrapper">
                {{-- cd-index-close скрывает кнопку меню на главной странице --}}
                <a @click="open = true" class="cd-dropdown-trigger cursor-pointer">{{ __('navigation.menu.name') }}</a>
                {{-- cd-index-open отображает меню на главной странице --}}
                <nav x-show="open"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     x-cloak
                     class="cd-dropdown cd-index-open">
                    <h2>{{ __('navigation.menu.name') }}</h2>
                    <a @click="open = false" class="cd-close cursor-pointer">{{ __('navigation.menu.close') }}</a>
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


