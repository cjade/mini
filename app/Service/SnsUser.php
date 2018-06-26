<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/26
 * Time: 下午9:13
 */
namespace App\Service;

use Illuminate\Support\Facades\Auth;

class SnsUser
{
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