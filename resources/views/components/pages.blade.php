@foreach($pages as $page)
    @php
        $page['url'] = $page['url'] ?? $page['id'];
        $active = ( '/' . request()->path() == route('pages', ['id' => $page['url']], false));
    @endphp

    <x-nav-link :href="route('pages', ['id' => $page['url']])" :active="$active" :type="$type">
        {{ $page['name'] }}
    </x-nav-link>
@endforeach
