@props(['active', 'type'])

@php
        if($type === 'mobile')
            $classes = ($active ?? false)
                ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sky-400 text-start text-base font-medium text-sky-700 bg-sky-50 focus:outline-none focus:text-sky-800 focus:bg-sky-100 focus:border-sky-700 transition duration-150 ease-in-out'
                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50  focus:border-gray-300 transition duration-150 ease-in-out';
        else
            $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sky-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-sky-700 transition duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    $classes = match($type){
        'mobile' => ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sky-400 text-start text-base font-medium text-sky-700 bg-sky-50 focus:outline-none focus:text-sky-800 focus:bg-sky-100 focus:border-sky-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out',

        'desktop' => ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sky-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-sky-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out',

        default => 'text-sm font-medium text-gray-600 hover:text-gray-900 text-center',
    };

@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
