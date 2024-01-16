<script type="module">
    onlyChangedData("f-table");
</script>
<form action="{{ route('admin.settings.update') }}" method="post" class="f-table">
@csrf
    <table class="container table-auto border border-collapse border-gray-400 mx-auto shadow-lg">
        <caption class="caption-bottom mt-3">
            <button class="rounded-xl shadow-lg w-1/4 p-2 text-white bg-sky-500
                hover:bg-sky-600 hover:shadow-xl">
                {{ __('admin/settings.button') }}
            </button>
        </caption>
        <thead>
        <tr class="bg-slate-50 divide-x">
            <th class="w-1/4 p-2">{{ __('admin/settings.key') }}</th>
            <th class="w-3/4 p-2">{{ __('admin/settings.value') }}</th>
        </tr>
        </thead>
        <tbody class="divide-y text-center">
        @foreach($settings as $setting)
            <tr class="divide-x hover:bg-slate-50">
                <td class="w-1/4">
                    {{--
                    <label>
                        <input hidden type="text" class="form-input m-1 w-3/4" value="{{  $setting['key'] }}"
                               name="key[{{  $setting['id'] }}]" maxlength="20" />
                    </label>
                    --}}
                    {{ $setting['key'] }}
                </td>
                <td class="w-3/4">
                    <input type="text" class="form-input m-1 w-5/6" value="{{ $setting['value'] }}"
                               id="value[{{ $setting['id'] }}]" name="value[{{ $setting['id'] }}]" maxlength="255" />
                    <label for="value[{{ $setting['id'] }}]" class="block text-sm text-left text-gray-400 px-6">
                        {{ __('admin/settings.description.' . $setting['key']) }}
                    </label>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</form>
