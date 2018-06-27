<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/26
 * Time: 下午4:51
 */

namespace App\Utils;

use Illuminate\Support\Facades\Auth;
define("GREETING", "Welcome");

class Utils
{

    const UserNotFound = '帐号名不存在-404';
    const NotFound     = '请求的资源不存在-404';


    /**
     * 第三方登录获取jwt token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * 返回json数据
     * @param $data
     * @return $this
     */
    public static function response($data){
        return response()->json($data)->header('Content-Type', 'application/json');
    }

    /**
     * 获取token
     * @param $user
     * @return mixed
     */
    public static function getToken($user){
        return $token = Auth::guard('api')->fromUser($user);
    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public static function getUser(){
        return Auth::guard('api')->user();
    }
}