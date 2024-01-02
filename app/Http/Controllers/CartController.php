<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
        if ($request->expectsJson()) {
            if ($request->json()->all()) {
                return var_dump($request->json()->all());
            }
        }
    }
}
