<?php

namespace App\View\Components;

use App\Models\StoreProduct;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Brand extends Component
{
    /**
     * @var array
     */
    public array $brands = [];

    /**
     * Create a new component instance.
     */
    public function __construct($sections)
    {
        $brands = StoreProduct::where(function ($query) use ($sections) {
                $query->whereIn('section', $sections);
                $query->where('visible', 1);
                $query->where('brand', '!=', '');
            })
            ->leftJoin('store_brands', 'store_products.brand', '=', 'store_brands.id')
            ->select('store_brands.id', 'store_brands.name')
            ->groupBy('store_brands.id', 'store_brands.name')
            ->orderBy('store_brands.name')
            ->get()->toArray();

        $this->brands = $brands;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.brand', ['brands' => $this->brands]);
    }
}
