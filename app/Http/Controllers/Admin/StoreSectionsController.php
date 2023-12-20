<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\StoreSections;
//use Illuminate\View\View;

class StoreSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = 0): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $id = (int) $id;
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        return View('admin.sections', [
            'list' => self::child($array_all, $id),
            'tree' => self::recurs($array_all, $id),
            //'message' => $request->get('message'),
            'id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Вид формы создания новой категории.
     */
    public function create(Request $request, $id): View|\Illuminate\Foundation\Application|Factory|Application|RedirectResponse
    {
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        if(!$id || StoreSections::where('id', (int) $id)->exists()) {
            return View('admin.sections-new', [
                'id' => (int)$id,
                //'message' => $request->get('message'),
                'tree' => self::recurs($array_all, (int)$id)
            ]);
        }
        else {
            $request->session()->flash('message', 'section-not-exist');
            return redirect()->route('admin.sections.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     * Валидация и insert новой категории.
     */
    public function store(Request $request, $id): RedirectResponse
    {
        $id = (int) $id;
        $validated = $request->validate([
            'name'    => 'string|max:64',
            'sort'    => 'integer|max:999',
            'visible' => 'boolean',
            'link'    => 'boolean',
        ]);

        $newSection = new StoreSections;

        $newSection->name = $validated['name'];
        $newSection->sort = $validated['sort'];
        $newSection->visible = $validated['visible'];
        $newSection->link = $validated['link'];
        $newSection->parent = $id;

        $newSection->save();

        $request->session()->flash('message', 'store');
        return redirect()->route('admin.sections.index',
            ['id' => $id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Валидация и update категории.
     */
    public function update(Request $request, $id = 0): RedirectResponse
    {
        $id = (int) $id;
        $validated = $request->validate([
            'name'    => 'array',
            'sort'    => 'array',
            'visible' => 'array',
            'link'    => 'array',
            'name.*'    => 'string|max:64',
            'sort.*'    => 'integer|min:-128|max:127',
            'visible.*' => 'boolean',
            'link.*'    => 'boolean',
            'id'      => 'integer'
        ]);

        // Вносим изменения
        foreach ($validated as $name => $item) {
            foreach ($item as $key => $value) {
                StoreSections::where('id', $key)->update([$name => $value]);
             }
        }

        $request->session()->flash('message', 'update');
        return redirect()->route('admin.sections.index',
            ['id' => $id]);
    }

    /**
     * Форма подтверждения удаления раздела и всех вложенных разделов.
     * @param $id
     * @return View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
     */
    public function delete($id): View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
    {
        $id = (int) $id;
        if(StoreSections::where('id', $id)->doesntExist())
            return redirect()->route('admin.sections.index');

        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        $array_del = self::recurs($array_all, $id, false);
        return View('admin.sections-delete', [
            'id' => $id,
            'tree' => self::recurs($array_all, $id),
            'delete' => $array_del
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $id = (int) $id;
        if(StoreSections::where('id', $id)->doesntExist())
            return redirect()->route('admin.sections.index');

        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        $array_del = self::recurs($array_all, $id, false);

        // ID родителя удаляемого раздела и его подразделов.
        $id_redirect = 0;
        foreach ($array_all as $el){
            if($id === $el['id'])
                $id_redirect = $el['parent'];
        }

        // Список удаляемых разделов.
        $key_del[] = $id;
        foreach ($array_del as $el){
            $key_del[] = $el['id'];
        }

        StoreSections::destroy($key_del);

        $request->session()->flash('message', 'delete');
        return redirect()->route('admin.sections.index',
            ['id' => $id_redirect]);
    }

    /**
     * Глубина вложенности разделов.
     * @param $array
     * @param $id
     * @param bool $direction *true - поиск parents* or *false - поиск children
     * @param array $search
     * @return array
     */
    private function recurs($array, $id, bool $direction = true, array &$search = []): array
    {
        foreach($array as $el){
            if(($direction ? $el['id'] : $el['parent']) === $id){
                $search[] = ['id' => $el['id'], 'name' => $el['name']];
                self::recurs($array, $direction ? $el['parent'] : $el['id'], $direction, $search);
            }
        }
        return $search;
    }

    /**
     * Вложенные разделы.
     * @param $array
     * @param $id
     * @return array
     */
    private function child($array, $id): array
    {
        $search = [];
        foreach($array as $el){
            if($el['parent'] === $id){
                $search[] = $el;
            }
        }
        return $search;
    }
}
