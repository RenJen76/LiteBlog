<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::get('user', function (Request $request) {
    dd($request->user());
})->middleware('auth:web');
*/

Route::get('index', 'ApiAuthController@index');
// Route::get('/comment/{article_id}', 'ArticleController@storeComment');
