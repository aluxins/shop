<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StorePages;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StorePagesController extends Controller
{
    public function index(Request $request)//: View|RedirectResponse
    {
        return view('admin.pages', ['pages' => StorePages::all()->sortBy('sort')->toArray()]);
    }

    public function update(Request $request, $id = 0)//: View|RedirectResponse
    {
        $id = (int) $id;

        return view('admin.pages-id', ['id' => $id, 'pages' => StorePages::find($id)->toArray()]);
    }

    public function create(Request $request, $id = 0)//: View|RedirectResponse
    {
        $data = $request->validate([
            'name' => 'nullable',
        ]);

        dd($data);
    }
}
