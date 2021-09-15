<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Image;
use App\User as User;
use App\Article as Article;
use App\Http\Requests\UserProfileRequest;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('user.auth')->except(
            'verifyUser', 'showUserProfile'
        );
        DB::enableQueryLog();
    }

    public function userIndex()
    {
        return view('user.default');
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
        } catch (Exception $e) {
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

    public function editUserInfo(UserProfileRequest $request)
    {
        $User = Auth::user();
        $User->email    = $request->input('email');
        $User->nickname = $request->input('username');
        $uploadFile     = $request->file('uploadImage');
        if ($uploadFile) {
            $Avatar = $this->createAvatar($uploadFile);
            $User->user_picture = $Avatar;
        }
        $User->save();
        return redirect('user/editUser')->withInput(['editSuccess' => 'success']);
    }

    public function createAvatar($uploadFile)
    {
        if(!isset($uploadFile) || $uploadFile === null){
            return null;
        }
        $Extension      = $uploadFile->getClientOriginalExtension();
        $FileName       = uniqid().'.'.$Extension;
        $RelativePath   = '/images/user/'.$FileName;
        $FullPath       = public_path($RelativePath);
        Image::make($uploadFile)->fit(300, 300)->save($FullPath);
        return $RelativePath;
    }

    public function showUserInfo()
    {
        return view('user.edit', ['UserData' => Auth::user()]);
    }

    public function showUserProfile($userId)
    {
        $User = User::findOrFail($userId);

        return view('user.profile', [
            'UserData'      => $User,
            'ArticleList'   => Article::where('user_id', $User->id)->with('Author', 'commits.commit_user')->get()
        ]);
    }
}