<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Article;
use App\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function __construct()
    {
        DB::enableQueryLog();
    }

    public function index()
    {
        $ArticleData = Article::where('article_status', '0')->with('Author', 'commits.commit_user')->get();

        Log::debug(DB::getQueryLog());

        return view('user.myArticles', [
            'Title'       => '所有文章',
            'UserData'    => $this->getUserData(),
            'ArticleList' => $ArticleData
        ]);
    }
}
