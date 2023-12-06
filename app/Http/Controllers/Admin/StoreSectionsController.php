<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreSections;
use Illuminate\View\View;

class StoreSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = (int) $request->id;
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        return View('admin.store-sections', [
            'list' => self::child($array_all, $id),
            'tree' => self::recurs($array_all, $id),
            'message' => $request->get('message'),
            'id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Вид формы создания новой категории.
     */
    public function create(Request $request)
    {
        $id = (int) $request->id;
        $array_all = StoreSections::orderBy('sort')->orderBy('id')->get()->toArray();
        return !$request->id || StoreSections::where('id', $request->id)->exists()
            ?
            View('admin.store-sections-new', [
                'id' => $id,
                'message' => $request->get('message'),
                'tree' => self::recurs($array_all, $id)
            ])
            :
            redirect()->route('admin.storesections.index',
                ['message' => 'section-not-exist']);
    }

    /**
     * Store a newly created resource in storage.
     * Валидация и insert новой категории.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'string|max:64',
            'sort'    => 'integer|max:999',
            'visible' => 'boolean',
            'link'    => 'boolean',
            'id'      => 'integer'
        ]);

        $newSection = new StoreSections;

        $newSection->name = $validated['name'];
        $newSection->sort = $validated['sort'];
        $newSection->visible = $validated['visible'];
        $newSection->link = $validated['link'];
        $newSection->parent = $request->id;

        $newSection->save();

        return redirect()->route('admin.storesections.index',
            ['message' => 'store', 'id' => $request->id]);
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
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'array',
            'sort'    => 'array',
            'visible' => 'array',
            'link'    => 'array',
            'name.*'    => 'string|max:64',
            'sort.*'    => 'integer|max:999',
            'visible.*' => 'boolean',
            'link.*'    => 'boolean',
            'id'      => 'integer'
        ]);
        //"name":{"50":"VZBUYN21"},
        //"sort":{"50":"3"},
        //"visible":{"50":"1"},
        //"link":{"50":"0"}

        //Определяем id измененных записей
        //$key = [];
        //foreach ($validated as $item) {
        //    $key = array_unique(array_merge(array_keys($item), $key));
        //}

        // Вносим изменения
        foreach ($validated as $name => $item) {
            foreach ($item as $key => $value) {
                StoreSections::where('id', $key)->update([$name => $value]);
             }
        }

        return redirect()->route('admin.storesections.index',
            ['message' => 'update', 'id' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Глубина вложенности разделов.
     * @param $array
     * @param $id
     * @param $search
     * @return array
     */
    private function recurs($array, $id, &$search = []): array
    {
        foreach($array as $el){
            if($el['id'] === $id){
                $search[] = ['id' => $id, 'name' => $el['name']];
                self::recurs($array, $el['parent'], $search);
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
