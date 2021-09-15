<?php

/**
 * other routes
*/
route::get('/', 'ArticleController@index');
route::get('/index', 'ArticleController@index');
route::get('/search/{searchContent}', 'ArticleController@searchContent');

/**
 * LineBot WebHook
*/
route::match(['get', 'post'],'/bot/response', 'LineBotController@webHook');

/**
 * 撰寫評論
*/
route::post('/writeComment/{article_id}', 'ArticleController@writeCommentProcess')->middleware('user.auth');

/**
 * 使用者功能
*/
route::group(['prefix' => 'user'], function(){
    route::get('index', 'UserController@userIndex');
    route::get('editUser', 'UserController@showUserInfo');
    route::post('editUser', 'UserController@editUserInfo');
    route::get('previewMailNotification', 'UserController@previewMailNotification');
    route::get('my-articles', 'ArticleController@showMyArticles');
    route::get('create-articles', 'ArticleController@addArticlesPage');
    route::post('create-articles', 'ArticleController@addArticlesProcess');
    route::get('edit-article/{article_id}', 'ArticleController@editArticlesPage');
    route::post('edit-article/{article_id}', 'ArticleController@editArticlesProcess');
});

/**
 * 使用者驗證
*/
route::get('verifyUser/{verify_code}', 'UserController@verifyUser');

/**
 * 登入控制
*/
route::group(['prefix' => 'auth'], function(){
    route::get('sign', 'AuthController@signUpPage');
    route::get('login', 'AuthController@loginPage')->name('login');
    route::post('logout', 'AuthController@signOutProcess');
    route::post('login-process', 'AuthController@loginProcess');
    route::post('register', 'AuthController@signUpProcess');
});

/**
 * 使用者頁面
*/
route::group(['prefix' => 'user'], function(){
    route::get('{user_id}', 'UserController@showUserProfile');
});