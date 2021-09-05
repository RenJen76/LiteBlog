<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

route::get('/', 'ArticleController@index');
route::get('/index', 'ArticleController@index');
route::get('/search/{searchContent}', 'ArticleController@searchContent');
// route::get('/updatedata', 'AuthController@updateData');
// route::get('/ts', 'ArticleController@ts');

route::match(['get', 'post'],'/bot/response', 'LineBotController@webHook');

/**
 * 簡易版登入
 */

route::group(['middleware'=>['user.auth']], function(){
    route::group(['prefix' => 'user'], function(){
        route::get('/index', 'UserController@userIndex');
        route::get('/editUser', 'UserController@showUserInfo');
        route::post('/editUser', 'UserController@editUserInfo');
        route::get('/previewMailNotification', 'UserController@previewMailNotification');
        route::get('/my-articles', 'ArticleController@showMyArticles');
        route::get('/create-articles', 'ArticleController@addArticlesPage');
        route::post('/create-articles', 'ArticleController@addArticlesProcess');
        route::get('/edit-article/{article_id}', 'ArticleController@editArticlesPage');
        route::post('/edit-article/{article_id}', 'ArticleController@editArticlesProcess');
    });
});

route::get('verifyUser/{verify_code}', 'UserController@verifyUser');
route::post('/writeComment/{article_id}', 'ArticleController@writeCommentProcess')->middleware('user.auth');

/**
 * Laravel版登入
 */
/*
route::group(['prefix' => 'account'], function(){
    route::get('/signIn', 'AccountController@signIn');
    route::get('/login', 'AccountController@login');
    route::post('/logOut', 'AccountController@logOut');
    route::post('/login-process', 'AccountController@loginProcess');
    route::post('/register', 'AccountController@register');
});

route::group(['prefix' => 'user-v2'], function(){
    route::get('/index', 'Userv2Controller@userIndex');
    route::get('/editUser', 'UserController@showUserInfo');
    route::post('/editUser', 'UserController@editUserInfo');
    route::get('/my-articles', 'ArticleController@showMyArticles');
    route::get('/create-articles', 'ArticleController@addArticlesPage');
    route::post('/create-articles', 'ArticleController@addArticlesProcess');
    route::get('/edit-article/{article_id}', 'ArticleController@editArticlesPage');
    route::post('/edit-article/{article_id}', 'ArticleController@editArticlesProcess');
});
*/

route::group(['prefix' => 'auth'], function(){
    route::get('/sign', 'AuthController@signUpPage');
    route::get('/login', 'AuthController@loginPage');
    route::post('/logout', 'AuthController@signOutProcess');
    route::post('/login-process', 'AuthController@loginProcess');
    route::post('/register', 'AuthController@signUpProcess');
});

route::group(['prefix' => 'user'], function(){
    route::get('/{user_id}', 'UserController@showUserProfile');
});
