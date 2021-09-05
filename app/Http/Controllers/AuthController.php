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
        session()->forget('UserID');
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
        session()->put('UserID', $account->id);
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

        Log::notice(print_r(DB::getQueryLog(), true));

        return redirect('/auth/login');
    }

    public function signOutProcess()
    {
        session()->forget('UserID');
        return redirect('/auth/login');
    }

    public function updateData()
    {
        /**
         * add record
         */
        // $Flights = Flight::where('sernum', 1)->limit(1);
        // $Flights->account = 'New Account Name';
        // $Flights->Save();
        
        /**
         * add record
         */
        // $Flights = Flight::create(['account' => 'abc']);
        
        /**
         * soft deleted
         */
        // $flight = Flight::find(1);
        // $flight->delete();
        
        /**
         * query record
         */
        // $Flight = Flight::find(2);
        // var_dump($Flight);
        // var_dump($Flight->trashed());
        // dd($Flight);
        try {       
            $flight = Flight::where([
                'id' => '10'
            ])->first();
            var_dump($flight['account']);
            exit;
            foreach ($flight as $key => $value) {
               $flight->account;
            }
            exit;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        /*
        foreach ($Flight as $key => $value) {
            echo "$value <hr>"; 
        }
        */
        
       
        return response([
            'key' => 'asw1254vvxs6d4ad6a5das46ads'
        ]);
       
        $Flights = Flight::where('id', 1);
        // dd($Flight->trashed());

        $Flights->Save();
        dd($Flights);
    }
}
