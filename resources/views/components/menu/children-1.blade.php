@props(['id', 'name', 'link', 'children'])

@if(!$link)
<li class="cd-divider">{{ $name }}</li>
@else
    @if(count($children) > 0)
        <li class="has-children">
    @else
        <li>
    @endif
    <a href="{{ $id }}">
        {{ $name }}
    </a>
    @if(count($children) > 0)
        <ul class="cd-secondary-dropdown is-hidden">
            <li class="go-back"><a href="#0">Menu</a></li>
            <li class="see-all"><a href="{{ $id }}">All {{ $name }}</a></li>
            @foreach($children as $el)
                <x-menu.children-2
                    :id="$el['id']"
                    :name="$el['name']"
                    :parent="$name"
                    :children="$el['children']"
                />
            @endforeach
        </ul>
    @endif
    </li>
@endif
