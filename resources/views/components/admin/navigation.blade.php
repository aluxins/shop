<!-- Navigation Links -->
<div class="grid grid-cols-3 gap-2 sm:gap-6 sm:flex sm:flex-row justify-around p-2 mb-4 border shadow-md">

    @foreach([
    'panel',
    'orders',
    'products',
    'sections',
    'pages',
    'settings',
    ] as $key => $val)

        @php
            $classes = (request()->routeIs('admin.'.$val.'.*') ?? false)
                        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sky-400 text-md font-medium leading-5 text-gray-900 focus:outline-none focus:border-sky-700 transition duration-150 ease-in-out'
                        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-md font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
        @endphp
        <div>
            <a class="{{$classes}}" href="{{ route('admin.' . $val . '.index')}}">
                {{ __('admin/navigation.' . $val) }}
            </a>
        </div>
    @endforeach
</div>
