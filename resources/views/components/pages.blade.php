@props(['count' => 0])
@foreach($pages as $page)
    @if($count != 0 and $loop->iteration > $count)
        @break
    @endif
    @php
        $page['url'] = $page['url'] ?? $page['id'];
        $active = ( '/' . request()->path() == route('pages', ['id' => $page['url']], false));
    @endphp

    <x-nav-link class="text-nowrap"
                :href="($page['url'] == 'index')
                    ? route('index')
                    : route('pages', ['id' => $page['url']])"
                :active="$active"
                :type="$type">
        {{ $page['name'] }}
    </x-nav-link>
@endforeach
