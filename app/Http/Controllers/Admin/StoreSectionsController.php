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
    public function index()
    {
        //return view('admin.store-sections')->with('list', StoreSections::all());
        return View('admin.store-sections', [
            'list' => StoreSections::all(),
            'message' => 'erererw3'
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
    public function update(Request $request, string $id)
    {
        //Здесь валидация и update новой категории
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
