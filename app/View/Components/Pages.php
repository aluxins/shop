<?php

namespace App\View\Components;

use App\Models\StorePages;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pages extends Component
{
    /**
     * @var string
     */
    public string $type;

    /**
     * Create a new component instance.
     */
    public function __construct($type = 'default')
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pages', [
            'pages' => cache()->rememberForever('pages-nav', function () {
                return StorePages::orderBy('sort')->orderBy('id')->select('id', 'name', 'url')->get()->toArray();
            }),
            'type' => $this->type
        ]);
    }
}
