@if($message)
    <div class="text-center w-1/2 text-2xl mt-12 p-2 mx-auto">
        @switch($message)
            @case('update')
                <div class="text-green-500">{{ __('Изменения сохранены') }}</div>
                @break

            @case('store')
                <div class="text-green-500">{{ __('Создано') }}</div>
                @break

            @case('section-not-exist')
                <div class="text-red-500">{{ __('Раздел не существует') }}</div>
                @break

            @case('delete')
                <div class="text-red-500">{{ __('Удалено') }}</div>
                @break

            @case('product-not-exists')
                <div class="text-red-500">{{ __('Товар не существует') }}</div>
                @break

            @case('image-delete')
                <div class="text-green-500">{{ __('Изображение удалено') }}</div>
                @break

            @case('image-not-exists')
                <div class="text-red-500">{{ __('Изображение не найдено') }}</div>
                @break

            @case('product-delete')
                <div class="text-green-500">{{ __('Товар удален') }}</div>
                @break

    @default

@endswitch

</div>
@endif
