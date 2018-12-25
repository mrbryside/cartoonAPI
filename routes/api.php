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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// auth //
Route::post('/login','ApiUserController@userLogin');
Route::post('/register','ApiUserController@userRegister');

// cartoon Query //
Route::middleware('auth:api')->post('/cartoonfollows','ApiCartoonController@cartoonFollow');
Route::middleware('auth:api')->get('/cartoonnews','ApiCartoonController@cartoonNewChapter');
Route::middleware('auth:api')->post('/cartoonlists','ApiCartoonController@cartoonList');
Route::middleware('auth:api')->get('/cartoonchapters/{cartoonID}','ApiCartoonController@cartoonChapter');
Route::middleware('auth:api')->get('/cartoonshow/{cartoonID}/{chapterID}','ApiCartoonController@cartoonShow');

