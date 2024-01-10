<form name="filter" method="post" >
    @csrf
    <div class="border-b flex flex-wrap sm:justify-end gap-4 m-2 pb-2">
        <label for="filter" class="block font-medium m-auto sm:m-0 text-gray-900 p-2">Filter</label>
        <div class="flex flex-nowrap justify-between w-full sm:w-min">
            <label>
                <input class="border rounded-xl" type="date" name="date-start" value="{{ old('date-start', '') }}" />
            </label>
            <span class="p-2">-</span>
            <label>
                <input class="border rounded-xl" type="date" name="date-end" value="{{ old('date-end', '') }}" />
            </label>
        </div>
        <div class="flex flex-nowrap justify-between w-full sm:w-min gap-x-4">
            <label>
                <select class="rounded-xl" name="status">
                    <option>Status</option>
                    <option>1</option>
                    <option>2</option>
                </select>
            </label>
            <button class="border bg-gray-100 rounded-lg p-2 w-1/3">OK</button>
        </div>
    </div>
</form>
