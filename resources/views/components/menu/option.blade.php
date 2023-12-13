@props(['id', 'name', 'link', 'children', 'selected', 'i'])


<option

    @if(!$link)
        disabled
    @else
        value="{{ $id }}"
        @if($selected == $id)
            selected
        @endif
    @endif

>
    @php
        echo str_repeat("-", $i)
    @endphp
    {{ $name }}
</option>
@if(count($children) > 0)
    @php
        $i++;
    @endphp
    @foreach($children as $el)
        <x-menu.option
            :id="$el['id']"
            :name="$el['name']"
            :link="$el['link']"
            :children="$el['children']"
            :selected="$selected"
            :i="$i"
        />
    @endforeach
@endif
