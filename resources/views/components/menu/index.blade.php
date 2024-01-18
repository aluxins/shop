@switch($type)
    @case('menu')
        {{-- https://codepen.io/martinridgway/pen/KVdKQJ --}}
        <div id="dropdown-menu">
            <div class="cd-dropdown-wrapper">
                {{-- cd-index-close скрывает кнопку меню на главной странице --}}
                <a class="cd-dropdown-trigger" href="#0">{{ __('navigation.menu.name') }}</a>
                {{-- cd-index-open отображает меню на главной странице --}}
                <nav class="cd-dropdown {{ $open ? 'cd-index-open' : '' }}">
                    <h2>{{ __('navigation.menu.name') }}</h2>
                    <a href="#" class="cd-close">{{ __('navigation.menu.close') }}</a>
                    <ul class="cd-dropdown-content">
                        {{-- Поле поиска
                        <li>
                            <form class="cd-search">
                                <input type="search" placeholder="Search...">
                            </form>
                        </li>
                        --}}
                            @foreach($arraySections as $el)
                                <x-menu.children-1
                                    :id="$el['id']"
                                    :name="$el['name']"
                                    :link="$el['link']"
                                    :children="$el['children']"
                                    base="{{route('catalog')}}"
                                />
                            @endforeach
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


