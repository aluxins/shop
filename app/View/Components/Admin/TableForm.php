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
    public string $action;

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
    public object $tbody;

    /**
     * Create a new component instance.
     * @param $action
     * @param $method
     * @param $thead
     * @param $tbody
     */
    public function __construct($action, $method, $thead, $tbody)
    {
        $this->action = $action;
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
