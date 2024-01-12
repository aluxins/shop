{{--
array = [
    uri => name
]
--}}
@props(['array'])
<div class="flex flex-nowrap truncate gap-2 sm:gap-4 text-gray-500 bg-white border rounded-xl shadow-sm mb-5">
    <div class="bg-gray-800 px-4 py-2 rounded-l-xl">
        <a class="text-gray-200 hover:text-white" href="{{ route('account.index') }}" title="{{ __('order.nav.home') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </a>
    </div>
    @foreach($array as $key => $val)
        <div class="py-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
        <div class="py-2 whitespace-nowrap">
            @if(!empty($val))
                <a class="hover:text-gray-900 " href="{{ $val }}">{{ $key }}</a>
            @else
                {{ $key }}
            @endif
        </div>
    @endforeach
</div>
