@props(['filter'])
<form class="" name="filter" method="post" action="{{ route('admin.orders.index') }}">
    @csrf
    <div class="flex flex-wrap sm:justify-end gap-4">
        <label for="filter" class="block font-medium m-auto sm:m-0 text-gray-900 p-2">{{ __('admin/orders.filter.name') }}</label>
        <div class="flex flex-nowrap justify-between w-full sm:w-min">
            <label>
                <input class="border rounded-xl" type="date" name="dateStart" value="{{ $filter['dateStart'] ?? '' }}" />
            </label>
            <span class="p-2">-</span>
            <label>
                <input class="border rounded-xl" type="date" name="dateEnd" value="{{ $filter['dateEnd'] ?? '' }}" />
            </label>
        </div>
        <div class="flex flex-nowrap justify-between w-full sm:w-min gap-x-4">
            <label>
                <select class="rounded-xl" name="status">
                    <option hidden value="">{{ __('admin/orders.filter.status') }}</option>
                    @foreach((!empty($siteSettings['order_status']) and is_array($siteSettings['order_status']))
                        ? $siteSettings['order_status'] : [] as $key => $value)
                        <option value="{{ $key }}"{{ (isset($filter['status']) and $key == $filter['status']) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </label>
            <button class="border bg-gray-100 rounded-lg p-2 w-1/3">{{ __('admin/orders.filter.button') }}</button>
        </div>
    </div>
    @if(count($filter) > 0)
        <div class="px-2 text-right text-sky-600 hover:text-sky-500">
            <a class="text-sm" href='{{ route('admin.orders.index') }}'>{{ __('admin/orders.filter.reset') }}</a>
        </div>
    @endif
</form>
