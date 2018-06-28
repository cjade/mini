<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:55
 */

Route::post('login', 'AuthController@login');
Route::post('login/{sns_type}', 'AuthController@snsLogin');
Route::put('refresh', 'AuthController@refresh');
Route::delete('logout', 'AuthController@logout');


//需登录
Route::middleware(['auth.api'])->group(function () {
    Route::get('me', 'AuthController@me');
    Route::get('index', 'AuthController@index');
});



