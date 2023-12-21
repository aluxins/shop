<x-app-layout>
    <x-admin.navigation />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('Store Sections') }}
</h2>
</x-slot>
<x-admin.alert />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-admin.tree
                        :tree="$tree"
                        route="admin.sections.index" />
                    <x-admin.table-form
                        method="PATCH"
                        thead=";#;Название раздела;Сортировка;Видимость;Гиперссылка;Изменить"
                        :tbody="$list"
                        :id="$id" />
            </div>
        </div>
    </div>
</div>
</x-app-layout>