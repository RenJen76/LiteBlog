<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Validator;
use App\User as User;
use App\Article as Article;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{

    function __construct()
    {
        DB::enableQueryLog();
    }

    public function previewMailNotification()
    {
        // $user = User::find(2);
        // event(new userEvents($user));
        /*
        return view('email.notification', [
            'nickName' => '阿伊恩',
            'verifyUrl'=> 'https://www.google.com.tw'
        ]);
        */
    }

    public function verifyUser($verify_code)
    {
        try {
            $userId = decrypt($verify_code);
        } catch (DecryptException $e) {
            abort(404);
        }

        $user = User::findOrFail($userId);
        
        if($user->verify_status=='0'){
            $user->verify_status = '1';
            $user->verify_at     = date('Y-m-d H:i:s');
            $user->save();
        }

        return redirect('index');

    }

    public function userIndex()
    {
        $User = $this->getUserData();

        if($User === null){
            return redirect('/auth/login');
        }

        return view('user.default', [
            'Title'     => '個人頁面',
            'UserData'  => $User
        ]);
    }

    public function editUserInfo()
    {
        $User = $this->getUserData();

        if($User === null){
            return redirect('/auth/login');
        }

        $Input      = Request()->All();
        $Validator  = Validator::make($Input, 
            array(
                'email' => [
                    'required',
                    'email'
                ],
                'username' => [
                    'required',
                    'max:15'
                ],
                'uploadImage' => [
                    'image',
                    'max:10240'
                ]
            )
        );

        $User->email    = $Input['email'];
        $User->nickname = $Input['username'];

        if($Validator->Fails()){
            $RsData         = array(
                'Title'         => '修改個人資訊',
                'UserData'      => $User,
                'EditSuccess'   => 'view'
            );
            return view('user.edit', $RsData)->WithErrors($Validator);
        }

        if(isset($Input['uploadImage']) && $Input['uploadImage'] != null){
            //取得檔案物件
            $Picture        = $Input['uploadImage'];
            //檔案副檔名
            $Extension      = $Picture->getClientOriginalExtension();
            //產生隨機檔案名稱
            $FileName       = uniqid().'.'.$Extension;
            //相對路徑
            $RelativePath   = '/images/user/'.$FileName;
            //取得public目錄下的完整位置
            $FullPath       = public_path($RelativePath);
            //裁切圖片
            Image::make($Picture)->fit(300, 300)->save($FullPath);
            //儲存圖片檔案相對位置
            $User->user_picture = $RelativePath;
        }

        $User->save();

        return view('user.edit', [
            'Title'         => '修改個人資訊',
            'UserData'      => $User,
            'EditSuccess'   => 'success'
        ]);
    }

    public function showUserInfo()
    {
        $User = $this->getUserData();

        if($User === null){
            return redirect('/auth/login');
        }

        return view('user.edit', [
            'Title'         => '修改個人資訊',
            'UserData'      => $User,
            'EditSuccess'   => 'view'
        ]);
    }

    public function showUserProfile($UserID)
    {
        $User = User::findOrFail($UserID);

        return view('user.profile', [
            'Title'         => '個人資訊',
            'UserData'      => $User,
            'ArticleList'   => Article::where('user_id', $User->id)->with('Author', 'commits.commit_user')->get()
        ]);
    }

}