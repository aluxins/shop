{{-- https://codepen.io/martinridgway/pen/KVdKQJ --}}
<div id="dropdown-menu" class="mx-5">
    <div class="cd-dropdown-wrapper">
        {{-- cd-index-close скрывает кнопку меню на главной странице --}}
        <a class="cd-dropdown-trigger" href="#0">Каталог</a>
        {{-- cd-index-open отображает меню на главной странице --}}
        <nav class="cd-dropdown cd-index-open">
            <h2>Title</h2>
            <a href="#0" class="cd-close">Close</a>
            <ul class="cd-dropdown-content">
                <li>
                    <form class="cd-search">
                        <input type="search" placeholder="Search...">
                    </form>
                </li>
                    @foreach($arraySections as $el)
                        <x-menu.children-1
                            :id="$el['id']"
                            :name="$el['name']"
                            :link="$el['link']"
                            :children="$el['children']"
                        />
                    @endforeach
            </ul>
        </nav>
    </div>
</div>



