@props(['activeBrands'])
<form class="m-4" method="post" action="{{ route('catalog.filter', ['id' => request()->route('id')]) }}">
    @csrf
    <div class="w-full p-3 border bg-white rounded-lg shadow block">
        <div class="mb-3 text-sm font-medium text-gray-900">
            Brand
        </div>
        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
            @foreach($brands as $brand)
            <li class="flex items-center">
                <label class="ml-2 text-sm font-medium text-gray-900">
                <input class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 focus:ring-2"
                       name="brands[{{ $brand['id'] }}]" type="checkbox" value="{{ $brand['id'] }}"
                       {{ in_array($brand['id'], $activeBrands) ? 'checked' : '' }}>
                    {{ $brand['name'] }}
                </label>
            </li>
            @endforeach
        </ul>
        <div class="mt-3">
            <button class="rounded-2xl border border-transparent bg-yellow-500 w-full text-sm text-white shadow-sm hover:bg-yellow-600">
                Применить
            </button>
        </div>
    </div>
</form>
