<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StorePages;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StorePagesController extends Controller
{
    public function index(): View|RedirectResponse
    {
        return view('admin.pages', ['pages' => StorePages::all()->sortBy('sort')->toArray()]);
    }

    public function update($id = 0): View|RedirectResponse
    {
        $id = (int) $id;

        return view('admin.pages-id', ['id' => $id, 'pages' => $id ? StorePages::find($id)->toArray() : [] ]);
    }

    public function store(Request $request, $id = 0): View|RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|max:100',
            'url' => 'nullable|max:100',
            'sort' => 'nullable|numeric|min:-127|max:127',
            'title' => 'nullable|max:255',
            'body' => 'nullable|max:65535',
        ]);

        $page = $id ? StorePages::find($id) : new StorePages();

        $page->name = $validated['name'];
        $page->url = $validated['url'];
        $page->sort = $validated['sort'];
        $page->title = $validated['title'];
        $page->body = $validated['body'];

        $page->save();

        //dd($validated, $id);

        $request->session()->flash('message', $id ? 'update' : 'store');
        return redirect()->route('admin.pages.update',
            ['id' => $page->id]);
    }
}
