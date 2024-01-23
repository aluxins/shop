<?php

namespace App\Http\Controllers;

use App\Models\StorePages;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    public function index($id): View
    {
        //$page = StorePages::where('id', $id)->orWhere('url', $id)->first();
        $page = cache()->rememberForever('page-'.$id, function () use ($id) {
            return StorePages::where('id', $id)->orWhere('url', $id)->first();
        });

        if(!$page) abort(404);

        return view('pages', ['page' => $page->toArray()]);

    }
}
