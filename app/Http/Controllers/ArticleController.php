<?php

namespace App\Http\Controllers;

use Log;
use Validator;
use App\Commit as commit;
use App\Article as article;
use App\Events\CommentReminderEvent;
use App\Mohist\MohistEncryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    function __construct()
    {
        $this->middleware('user.auth')->except(
            'searchContent', 'index'
        );
    }

    public function index()
    {
        $ArticleData = article::where('article_status', '0')->with('Author', 'commits.commit_user')->orderby('article_id', 'DESC')->get();

        return view('article.index', [
            'Title'         => '所有文章',
            'ArticleList'   => $ArticleData
        ]);
    }

    public function writeCommentProcess(request $request, $articleId)
    {        
        $commentContent = $request->input('commentContent');
        if(!$commentContent){
            return response()->json([
                'responseMessage' => '內容不得為空'
            ]);
        }

        $article = article::where('article_id', $articleId)->active()->first();
        if($article === null){
            return response()->json([
                'responseMessage' => '文章不存在'
            ]);
        }

        $commit = commit::create([
            'article_id'    => $article->article_id,
            'user_id'       => Auth::id(),
            'commit_content'=> $commentContent,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        event(new CommentReminderEvent($article));

        return response()->json([
            'responseMessage' => '建立成功'
        ]);
    }

    public function addArticlesPage()
    {
        return view('user.addArticles', [
            'Title'         => '新增文章',
            'ProcessResult' => 'view'
        ]);
    }

    public function addArticlesProcess()
    {
        $Input      = Request()->All();
        $Validator  = Validator::make($Input, array(
            'contentTitle' => array(
                'required', 'max:50'
            ),
            'content' => array(
                'required'
            )
        ));

        if($Validator->Fails()){
            return redirect('user/create-articles')->WithErrors($Validator)->WithInput();
        }

        $ArticleData = [
            'user_id'           => Auth::id(),
            'article_title'     => $Input['contentTitle'],
            'article_content'   => $Input['content']
        ];
        

        article::create($ArticleData);
        return redirect('/user/create-articles')->with('ProcessResult', 'success');
    }

    public function showMyArticles()
    {
        $ArticleList = article::where('user_id', Auth::id())->with('Author')->get();
        return view('user/myArticles', [
            'Title'         => '我的文章列表',
            'ArticleList'   => $ArticleList
        ]);
    }

    public function searchContent($Content)
    {
        $articleList = article::where('article_content', 'like', '%' . $Content . '%')->get();
        return view('article.search', [
            'Title'         => '\'' . $Content . '\'' . ' 搜尋結果',
            'ArticleList'   => $articleList,
            'SearchContent' => $Content
        ]);
    }

    public function editArticlesPage($ArticleID)
    {
        $ArticleData    = article::where([
            'user_id'       =>  Auth::id(),
            'article_id'    =>  $ArticleID,
        ])->FirstOrFail();

        return view('user/editArticles', [
            'Title'         => '修改文章',
            'ArticleData'   => [
                'ArticleTitle'      => $ArticleData->article_title,
                'ArticleContent'    => $ArticleData->article_content
            ]
        ]);
    }

    public function editArticlesProcess($ArticleID)
    {
        $Input      = Request()->All();
        $Validator  = Validator::make($Input, array(
            'contentTitle' => array(
                'required', 'max:50'
            ),
            'content' => array(
                'required'
            )
        ));

        if($Validator->Fails()){
            return redirect('user/create-articles')->WithErrors($Validator)->WithInput();
        }

        article::where([
            'user_id'           =>  Auth::id(),
            'article_id'        =>  $ArticleID,
        ])->update([
            'updated_at'        => date('Y-m-d H:i:s'),
            'article_title'     => $Input['contentTitle'],
            'article_content'   => $Input['content']
        ]);

        return redirect('user/edit-article/' . $ArticleID)
                ->with('ProcessResult', 'success');
    }
}
