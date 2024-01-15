<form method="post" action="{{route('admin.products.search')}}">
    @csrf
    {{ __('admin/products.search.name') }}
    <label class="font-medium">{{ __('admin/products.search.article') }}
        <input name="searchArticle" value="{{old('searchArticle')}}" />
    </label>
    {{ __('admin/products.search.or') }}
    <label class="font-medium">{{ __('admin/products.search.id') }}
        <input name="searchId" value="{{old('searchId')}}" />
    </label>
    <button class="border p-2 rounded-2xl shadow bg-gray-100 hover:bg-gray-50">{{ __('admin/products.search.button') }}</button>
</form>
