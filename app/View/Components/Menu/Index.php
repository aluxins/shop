<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\StoreSections;
use App\Helpers\RecursionArray;

class Index extends Component
{
    /**
     * @var array
     */
    public array $arraySections;

    /**
     * @var array
     */
    public array $arrayTree;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $selected;

    /**
     * @var bool
     */
    public bool $open;

    /**
     * Create a new component instance.
     * @param int $idStart Начальный ID родителя
     * @param string $type Тип меню
     * @param string $selected Выбранный пункт списка select
     * @param bool $open true - открытое меню
     */
    public function __construct(int $idStart = 0, string $type = 'menu', string $selected = '', bool $open = false)
    {
        $array_all = cache()->rememberForever('sections-db', function () {
            return StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        });
        $this->arraySections = cache()->rememberForever('sections-multi', function () use($array_all) {
            return RecursionArray::multidimensional($array_all);
        });
        $this->arrayTree = RecursionArray::depth($array_all, $idStart);
        $this->type = $type;
        $this->selected = $selected;
        $this->open = $open;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.index', ['type' => $this->type]);
    }

}
