<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'refresh', '']]);
    }

    public function index(Request $request)
    {
        // dd(session()->all());
        // dd($request->all());
        dd(Auth::check());
        dd($request->age);
        
    }
}
