<?php

namespace App\Http\Controllers;

use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request, int $id = 0): View
    {


        return view('catalog', [
            'id' => $id,
            'products' => StoreProduct::where(function ($query) use ($id) {
                $query->where('section', $id);
            })->get()->toArray(),
        ]);
    }
}
