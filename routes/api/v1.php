<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:55
 */


Route::post('/login', 'AuthController@index');

Route::get('/index', 'AuthController@index');
Route::get('/index1', 'AuthController@index1');