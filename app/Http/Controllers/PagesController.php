<?php

namespace App\Http\Controllers;

use App\Models\StorePages;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function index($id = 'index'): View
    {
        $page = cache()->rememberForever('page-'.$id, function () use ($id) {
            return StorePages::where('id', $id)->orWhere('url', $id)->first();
        });

        if(!$page) abort(404);

        return view('pages', ['page' => $page->toArray()]);

    }
}
