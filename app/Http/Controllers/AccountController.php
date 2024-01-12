<?php

namespace App\Http\Controllers;

use App\Models\StoreOrders;
use App\Models\StoreProfiles;
//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        return view('account', [
            'user' => $request->user(),
            'information' => StoreProfiles::where('user', $request->user()->id)
                ->select('first_name','last_name','patronymic','city','street_address',
                    'telephone','about')->first(),
            'orders' => StoreOrders::where('user', $request->user()->id)
                ->where('status', '!=', '5')
                ->orderByDesc('id')->limit(5)->get()->toArray()
        ]);
    }
}
