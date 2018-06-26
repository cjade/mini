<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:55
 */

Route::post('login', 'AuthController@login');
Route::post('login/{sns_type}', 'AuthController@snsLogin');

Route::delete('logout', 'AuthController@logout');
Route::put('refresh', 'AuthController@refresh');
Route::get('me', 'AuthController@me');
Route::get('index', 'AuthController@index');