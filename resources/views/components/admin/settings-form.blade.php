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
                    @if(explode(':', $setting['options'])[0] == 'enum')
                        <label>
                            <select name="value[{{ $setting['id'] }}]" class="m-1 w-5/6">
                                @foreach(explode(',', explode(':', $setting['options'])[1]) as $key => $value)
                                    <option value="{{ $value }}"{{ $setting['value'] == $value ? ' selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </label>
                    @elseif($setting['options'] == 'array')
                        <label>
                            <textarea name="value[{{ $setting['id'] }}]" class="m-1 w-5/6">{{ implode("\n", json_decode($setting['value'], true)) }}</textarea>
                        </label>
                    @elseif($setting['options'] == 'boolean')
                        <label>
                            <select name="value[{{ $setting['id'] }}]" class="m-1 w-5/6">
                                <option value="1"{{ $setting['value'] == 1 ? ' selected' : '' }}>On</option>
                                <option value="0"{{ $setting['value'] == 0 ? ' selected' : '' }}>Off</option>
                            </select>
                        </label>
                    @elseif($setting['options'] == 'string')
                        <label><input type="text" class="m-1 w-5/6" value="{{ $setting['value'] }}"
                                id="value[{{ $setting['id'] }}]" name="value[{{ $setting['id'] }}]" maxlength="255" />
                        </label>
                    @else
                        {{ $setting['value'] }}
                    @endif
                    <div class="block text-sm text-left text-gray-400 px-6">
                        {{ __('admin/settings.description.' . $setting['key']) }}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</form>
