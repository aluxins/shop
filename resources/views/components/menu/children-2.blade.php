@props(['id', 'name', 'children', 'parent', 'base'])
<li class="@if(count($children) > 0) has-children @endif">
    <a href="{{ $base }}/{{ $id }}">
        {{ $name }}
    </a>

    @if(count($children) > 0)
        <ul class="is-hidden">
            <li class="go-back"><a href="#0">{{ $parent }}</a></li>
            <li class="see-all"><a href="{{ $base }}/{{ $id }}">All {{ $name }}</a></li>
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
