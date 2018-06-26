<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:55
 */

Route::post('login', 'AuthController@login');
Route::post('login/{sns_type}', 'AuthController@snsLogin');

Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::post('me', 'AuthController@me');
Route::get('index', 'AuthController@index');