<form method="post" >
    @csrf
    Поиск по
    <label class="font-medium">артикулу
        <input name="search" value="" />
    </label>
    или
    <label class="font-medium">ID
        <input name="search" value="" />
    </label>
    <button>Искать</button>
</form>
