<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tree extends Component
{
    /**
     * @var array
     */
    public array $tree = [];
    /**
     * @var string
     */
    public string $route;
    /**
     * Create a new component instance.
     */
    public function __construct($tree, $route)
    {
        $this->tree = $tree;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.tree');
    }
}
