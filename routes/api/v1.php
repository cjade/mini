<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:55
 */


Route::get('/login', function (){
    dd(12);
});

Route::get('/index', 'AuthController@index');