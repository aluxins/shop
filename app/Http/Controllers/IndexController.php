<?php

namespace App\Http\Controllers;

use App\Models\StorePages;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $page = StorePages::where('url', 'index')->first();

        return view('index', ['page' => $page ? $page->toArray() : []]);
    }
}
