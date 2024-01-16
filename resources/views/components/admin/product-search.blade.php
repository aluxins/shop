<form class="flex flex-col sm:flex-row gap-2" method="post" action="{{route('admin.products.search')}}">
    @csrf
    <div class="flex justify-end gap-2">
        <span class="font-medium pt-2">
            {{ __('admin/products.search.name') }}
        </span>
        <label>
            <input name="searchArticle" value="{{old('searchArticle')}}" placeholder="{{ __('admin/products.search.article') }}" />
        </label>
    </div>
    <div class="flex justify-end gap-2">
        <span class="font-medium pt-2">
            {{ __('admin/products.search.or') }}
        </span>
        <label>
            <input name="searchId" value="{{old('searchId')}}" placeholder="{{ __('admin/products.search.id') }}" />
        </label>
    </div>
    <div class="text-right">
        <button class=" p-2 rounded-2xl shadow bg-gray-100 hover:bg-gray-50">
            {{ __('admin/products.search.button') }}
        </button>
    </div>
</form>
