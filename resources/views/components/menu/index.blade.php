<div>

    @php
        echo str_replace(
            [
                '[ul]',
                '[/ul]',
                '[li]',
                '[/li]'
                ],
            [
                '<ul class="list-disc">',
                '</ul>',
                '<li>',
                '</li>'
                ],
            $ulSections);
            //var_dump($arraySections)
    @endphp
</div>
