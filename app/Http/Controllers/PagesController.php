<?php

namespace App\Http\Controllers;

use App\Models\StorePages;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function index($id): View
    {
        $page = StorePages::where('id', $id)->orWhere('url', $id)->first();

        if($page)
            return view('pages', ['page' => $page->toArray()]);
        else
            abort(404);
    }
}
