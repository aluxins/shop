<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StorePanelController extends Controller
{
    public function index(): View
    {
        //SELECT TABLE_NAME, TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'laravel';
        $tables = DB::table('INFORMATION_SCHEMA.TABLES')
            ->select('TABLE_NAME', 'TABLE_ROWS')
            ->where('TABLE_SCHEMA', config('database.connections.' . config('database.default') . '.database'))
            ->whereIn('TABLE_NAME', [
                'store_orders','store_pages','store_products','store_sections','store_settings','users'
            ])
            ->get()->toArray();

        return view('admin.panel', ['tables' => $tables]);
    }

}
