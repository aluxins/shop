@props(['id', 'name', 'link', 'children', 'base'])

@if(!$link)
<li class="cd-divider">{{ $name }}</li>
@else
    @if(count($children) > 0)
        <li class="has-children">
    @else
        <li>
    @endif
    <a href="{{ $base }}/{{ $id }}">
        {{ $name }}
    </a>
    @if(count($children) > 0)
        <ul class="cd-secondary-dropdown is-hidden lg:rounded-r-xl lg:shadow-xl">
            <li class="go-back"><a href="#">{{ __('navigation.menu.name') }}</a></li>
            <li class="see-all"><a href="{{ $base }}/{{ $id }}" class="lg:rounded-xl">{{ __('navigation.menu.all') }} {{ $name }}</a></li>
            @foreach($children as $el)
                <x-menu.children-2
                    :id="$el['id']"
                    :name="$el['name']"
                    :parent="$name"
                    :children="$el['children']"
                    :base="$base"
                />
            @endforeach
        </ul>
    @endif
    </li>
@endif
