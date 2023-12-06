@if($message)
    <div class="text-center w-1/2 text-2xl mt-12 p-2 mx-auto">
        @switch($message)
            @case('update')
                <div class="text-green-500">{{ __('Изменения сохранены') }}</div>
                @break

            @case('store')
                <div class="text-green-500">{{ __('Новый раздел создан') }}</div>
                @break

            @case('section-not-exist')
                <div class="text-red-500">{{ __('Раздел не существует') }}</div>
                @break

            @default

        @endswitch

</div>
@endif
