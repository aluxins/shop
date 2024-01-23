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

    public function update(Request $request, $id = 0): View|RedirectResponse
    {
        $page = StorePages::find((int) $id);
        if(is_null($page) and $id != 0){
            $request->session()->flash('message', 'page-not-exist');
            return redirect()->route('admin.pages.index');
        }
        else
            return view('admin.pages-id', ['id' => $id, 'pages' => ($id != 0) ? $page->toArray() : []]);
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

        if (is_null($page)) abort(404);

        $page->name = $validated['name'];
        $page->url = $validated['url'];
        $page->sort = $validated['sort'];
        $page->title = $validated['title'];
        $page->body = $validated['body'];

        $page->save();

        if ($id) self::removeCache($page);

        $request->session()->flash('message', $id ? 'update' : 'store');
        return redirect()->route('admin.pages.update',
            ['id' => $page->id]);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $page = StorePages::find($id);

        if(is_null($page))abort(404);

        self::removeCache($page);

        $page->delete();

        $request->session()->flash('message', 'delete');
        return redirect()->route('admin.pages.index');
    }

    /**
     * Отчистка кэша
     * @param $page
     * @return void
     */
    public function removeCache($page): void
    {
        cache()->forget('page-'.$page->id);
        cache()->forget('page-'.$page->url);
        cache()->forget('pages-nav');
    }
}
