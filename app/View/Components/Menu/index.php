<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\StoreSections;

class index extends Component
{
    /**
     * @var array
     */
    public array $arraySections;

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
        $this->arraySections = $this->recurs(
            StoreSections::orderBy('sort')->orderBy('id')->get()->toArray(),
            $idStart);
        $this->type = $type;
        $this->selected = $selected;
        $this->open = $open;
    }

    /**
     * @param array $array
     * @param int $id
     * @return array
     */
    public function recurs(array $array, int $id = 0): array
    {
        $search = [];
        foreach($array as $el){
            if($el['parent'] === $id) {
                $search[] = [
                    'id' => $el['id'],
                    'name' => $el['name'],
                    'link' => $el['link'],
                    'children' => self::recurs($array, $el['id'])
                ];
            }
        }
        return $search;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.index', ['type' => $this->type]);
    }

}
