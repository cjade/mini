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

    /**
     * 第三方登录获取jwt token
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondWithToken ($token)
    {
        return $data = [
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60
        ];
    }


    /**
     * 获取token
     * @param $user
     * @return mixed
     */
    public static function getToken ($user)
    {
        return $token = Auth::guard('api')->fromUser($user);
    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public static function getUser ()
    {
        return Auth::guard('api')->user();
    }

    /**
     * 验证用户是否登录
     * @return mixed
     */
    public static function authCheck ()
    {
        return Auth::guard('api')->check();
    }
}