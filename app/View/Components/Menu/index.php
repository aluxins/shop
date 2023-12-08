<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\StoreSections;

class index extends Component
{
    /**
     * @var string
     */
    public string $ulSections;

    public static $ulSSections;
    /**
     * @var array
     */
    public array $arraySections;
    /**
     * Create a new component instance.
     */
    public function __construct($idStart, $tabI)
    {
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        $this->arraySections = $this->recurs($array_all, $idStart, $tabI);
        $this->ulSections = self::$ulSSections;
    }

    public function recurs(array $array, int $id = 0, int $i = 0){
        $i++;
        $search = [];
        $tab = "    ";
        foreach($array as $el){
            if($el['parent'] === $id){
                self::$ulSSections .= "\n" . str_repeat($tab, $i) . "[ul]";
                self::$ulSSections .= "\n" . str_repeat($tab, $i) . "[li]" . $el['name'];
                $search[] = [
                    'name' => $el['name'],
                    'children' => self::recurs($array, $el['id'], $i)
                ];
                self::$ulSSections .= "\n" . str_repeat($tab, $i) . "[/li]";
                self::$ulSSections .= "\n" . str_repeat($tab, $i) . "[/ul]";
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
