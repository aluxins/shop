<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableForm extends Component
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $method;

    /**
     * @var array
     */
    public array $thead;

    /**
     * @var object
     */
    public array $tbody;

    /**
     * Create a new component instance.
     * @param $id
     * @param $method
     * @param $thead
     * @param $tbody
     */
    public function __construct($id, $method, $thead, $tbody)
    {
        $this->id = $id;
        $this->method = $method;
        $this->thead = explode($thead[0], substr($thead, 1, strlen($thead)));
        $this->tbody = $tbody;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.table-form');
    }
}
