<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSettings;
use App\Providers\SiteSettingsProvider;
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
                $setting = StoreSettings::where('id', (int) $key);

                // Преобразование значения в массив при необходимости.
                if($setting->first()->options === 'array')$value = json_encode(explode("\r\n", $value));

                $setting->update([$name => $value]);
            }
        }

        // Отчистка кэша siteSettings
        cache()->forget('siteSettings');

        // Перезагрузка кэша siteSettings
        SiteSettingsProvider::StoreSettings();

        $request->session()->flash('message', 'update');
        return redirect()->route('admin.settings.index');
    }
}
