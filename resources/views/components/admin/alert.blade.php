@if($message)
    <div class="text-center text-2xl pt-12">
        @switch($message)
            @case('save')
                {{ __('Изменения сохранены') }}
                @break

            @case(2)

                @break

            @default

        @endswitch

</div>
@endif
