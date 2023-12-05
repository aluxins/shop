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
        //return view('admin.store-sections')->with('list', StoreSections::all());
        return View('admin.store-sections', [
            'list' => StoreSections::all(),
            'message' => $request->get('message')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Здесь вид формы создания новой категории
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Здесь валидация и insert новой категории

        $validated = $request->validate([
            'name'    => 'array',
            'sort'    => 'array',
            'visible' => 'array',
            'link'    => 'array',
            'name.*'    => 'string|max:64',
            'sort.*'    => 'integer|max:999',
            'visible.*' => 'boolean',
            'link.*'    => 'boolean',
        ]);
        //"name":{"50":"VZazoBUYN21"},
        //"sort":{"50":"3"},
        //"visible":{"50":"1"},
        //"link":{"50":"0"}

        return $request->post();
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
        //Форма для редактирования категории
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Валидация и update категории
        $validated = $request->validate([
            'name'    => 'array',
            'sort'    => 'array',
            'visible' => 'array',
            'link'    => 'array',
            'name.*'    => 'string|max:64',
            'sort.*'    => 'integer|max:999',
            'visible.*' => 'boolean',
            'link.*'    => 'boolean',
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
            foreach ($item as $id => $value) {
                StoreSections::where('id', $id)->update([$name => $value]);
             }
        }

        return redirect()->route('admin.storesections.index',
            ['message' => 'save']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
