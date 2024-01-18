<x-app-layout>

    <x-slot name="title">
        {{ $id ? __('admin/pages.titleId', ['id' => $id]) : __('admin/pages.titleNew') }}
    </x-slot>

    <x-slot name="heading">
        {{ $id ? __('admin/pages.titleId', ['id' => $id]) : __('admin/pages.titleNew') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.navigation />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
                <x-admin.error />
                    <form method="post" action="{{ route('admin.pages.store', ['id' => $id]) }}">
                        @csrf
                        <table class="table-auto w-full divide-y divide-gray-200 border-spacing-2 rounded-xl">
                            {{--
                            <caption class="caption-top text-xl py-4">
                                {{ $id ? __('admin/pages.titleId', ['id' => $id]) : __('admin/pages.titleNew') }}
                            </caption>
                            --}}
                            <caption class="caption-bottom py-4">
                                <button class="rounded-xl shadow-lg w-1/4 p-2 text-white
                                bg-sky-500 hover:bg-sky-600 hover:shadow-xl">
                                    {{ __('admin/pages.button') }}
                                </button>
                            </caption>
                            <tbody class="divide-y text-center">
                            @foreach(['name' => 100, 'url' => 100, 'sort' => 3, 'title' => 255] as $key => $maxlength)
                                <tr class="divide-x hover:bg-slate-50">
                                    <td class="font-medium">
                                        {{ __('admin/pages.' . $key) }}
                                    </td>
                                    <td>
                                        <label>
                                            <input class="form-input m-1 w-3/4" type="{{ $key === 'sort' ? 'number' : 'text' }}"
                                                   maxlength="{{ $maxlength }}" name="{{ $key }}" value="{{ !empty(old($key)) ? old($key) : $pages[$key] ?? '' }}" />
                                        </label>
                                    </td>
                                </tr>
                            @endforeach

                                <tr class="divide-x hover:bg-slate-50">
                                    <td colspan="2">
                                        <label for="body"></label>
                                        <textarea class="wysiwyg w-full h-96" id="body" name="body">{{ !empty(old('body')) ? old('body') : $pages['body'] ?? '' }}</textarea>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </form>
                    <div class="w-full text-right p-4">
                        <form method="post" action="{{route('admin.pages.delete', ['id' => $id])}}">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button>
                                {{ __('admin/pages.delete') }}
                            </button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
