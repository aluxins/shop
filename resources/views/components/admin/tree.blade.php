<div>
    @if(count($tree) > 0)
        <a href="{{ route($route) }}">
            В начало
        </a>
    @endif
    @php
        krsort($tree);
    @endphp
    @foreach($tree as $el)
        / <a href="{{ route($route, ['id' => $el['id']]) }}">
            {{ $el['name'] }}
        </a>
    @endforeach
</div>
