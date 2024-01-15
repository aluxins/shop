<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreSettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings', ['settings' => StoreSettings::all()->toArray()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'value'    => 'array',
            'value.*'    => 'string|max:255',
        ]);

        // Вносим изменения
        foreach ($validated as $name => $item) {
            foreach ($item as $key => $value) {
                StoreSettings::where('id', (int) $key)->update([$name => $value]);
            }
        }

        // Отчистка кэша
        cache()->forget('siteSettings');

        $request->session()->flash('message', 'update');
        return redirect()->route('admin.settings.index');
    }
}
