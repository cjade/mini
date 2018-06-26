<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/26
 * Time: 下午4:51
 */

namespace App\Utils;

use Illuminate\Support\Facades\Auth;


class Utils
{
    const UserNotFound = '帐号名不存在-404';
    const NotFound     = '请求的资源不存在-404';


    public static function response ()
    {

    }

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
}