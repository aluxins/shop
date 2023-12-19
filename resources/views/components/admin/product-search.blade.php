<form method="post" action="{{route('admin.products.search')}}">
    @csrf
    Поиск по
    <label class="font-medium">артикулу
        <input name="searchArticle" value="{{old('searchArticle')}}" />
    </label>
    или
    <label class="font-medium">ID
        <input name="searchId" value="{{old('searchId')}}" />
    </label>
    <button>Искать</button>
</form>
