<?php

namespace App\Http\Controllers;

use Validator;
use App\User as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mohist\MohistEncryption as MohistEncryption;

class AccountController extends Controller
{

    function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    public function signIn()
    {
        return view('register.login', [
            'Title' => '登入頁面'
        ]);
    }

    public function login()
    {
        return view('register.login', [
            'Title' => '登入頁面'
        ]);
    }

    public function loginProcess()
    {
        $Input      = Request()->All();
        $Validator  = Validator::make($Input, 
            array(
                'account' => [
                    'required'
                ],
                'password' => [
                    'required'
                ]
            )
        );
        if($Validator->Fails()){
            return redirect('/auth/login')->WithErrors($Validator)->withInput();
        }
        
        $PassWordEncrytion  = MohistEncryption::Encrypt($Input['password']);
        $Account = User::where('account', $Input['account'])->where('password', $PassWordEncrytion)->first();
        if($Account === null){
            return redirect('/auth/login')->WithErrors([
                'msg' => [
                    '帳號或密碼輸入錯誤'
                ]
            ])->withInput();
        }

        Auth::login($Account);
        return redirect('/user-v2/index');
    }
}
