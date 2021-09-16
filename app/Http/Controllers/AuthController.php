<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\User as User;
use App\Events\UserEvents;
use App\Http\Requests\SignInRequest;
use App\Tool\DataEncryption;
use Validator;

class AuthController extends Controller
{

    function __construct()
    {
        $this->middleware('guest')->except('signOutProcess');
        DB::enableQueryLog();
    }

    public function signUpPage()
    {
        return view('register.sign', [
            'Title' => '註冊頁面'
        ]);
    }

    public function loginPage()
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
        $PassWordEncrytion  = DataEncryption::Encrypt($Input['password']);
        $account = User::where([
            'account'  => $Input['account'],
            'password' => $PassWordEncrytion
        ])->first();
        
        if($account === null){
            return redirect('/auth/login')->WithErrors([
                'msg' => [
                    '帳號或密碼輸入錯誤'
                ]
            ])->withInput();
        }

        if($account->verify_status=='0'){
            return redirect('/auth/login')->WithErrors([
                'msg' => [
                    '請先完成Email認證程序'
                ]
            ])->withInput();
        }

        Auth::login($account);
        return redirect()->intended('/user/index');
    }

    public function signUpProcess(SignInRequest $request)
    {
        $user = User::create([
            'account'   => $request['account'],
            'password'  => DataEncryption::Encrypt($request['password']),
            'nickname'  => $request['nickname'],
            'email'     => $request['email']
        ]);
        event(new UserEvents($user));
        return redirect()->route('login');
    }

    public function signOutProcess()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}