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
     * Create a new component instance.
     * @param int $idStart Начальный ID родителя
     * @param int $tabI Начальное значение отступов
     */
    public function __construct(int $idStart = 0, int $tabI = 0)
    {
        $this->arraySections = $this->recurs(
            StoreSections::orderBy('sort')->orderBy('id')->get()->toArray(),
            $idStart,
            $tabI);
    }

    /**
     * @param array $array
     * @param int $id
     * @param int $i
     * @return array
     */
    public function recurs(array $array, int $id = 0, int $i = 0): array
    {
        $search = [];
        foreach($array as $el){
            if($el['parent'] === $id) {
                $search[] = [
                    'id' => $el['id'],
                    'name' => $el['name'],
                    'link' => $el['link'],
                    'children' => self::recurs($array, $el['id'], $i)
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
        return view('components.menu.index');
    }

}
