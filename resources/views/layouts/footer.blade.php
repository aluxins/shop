<div class="mt-6 w-full sm:w-3/4 mx-auto">

    <div class="grid grid-cols-2 gap-4 sm:flex sm:flex-row justify-around p-2 sm:gap-6">
        <x-pages type="" />
    </div>
    <div class="py-6 text-sm text-gray-500 text-center">
        {{ $siteSettings['footer_copyright'] ?? '' }}
    </div>
</div>
