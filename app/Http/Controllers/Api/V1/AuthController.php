<?php
/**
 * 账号模块
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:48
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Exceptions\ApiException;
use App\Utils\Utils;

class AuthController extends ApiController
{

    /**
     * @api {get} /index 接口测试
     * @apiVersion       1.0.0
     * @apiDescription 根据ID（id）获取列表信息
     * @apiGroup accountGroup
     *
     * @apiParam {Number} id 任务ID
     * @apiParam {Number} [page] 页数
     * @apiParam {Number} [perpage] 每页的条数s
     *
     * @apiUse InvalidToken
     */
    public function index()
    {
        return response()->json('12');
    }

    /**
     * @api {post} /login 登录
     * @apiVersion       1.0.0
     * @apiDescription 账号密码登录
     * @apiGroup accountGroup
     * @apiPermission    none
     *
     * @apiParam {String} user_name 账号[邮箱或手机号]
     * @apiParam {String{6..30}} password 密码
     *
     * @apiSuccess {String} access_token token
     * @apiSuccess {String} token_type 类型
     * @apiSuccess {Integer} expires_in 过期时间
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlkZXYubWNvby5tZVwvdjFcL2xvZ2luXC93ZWl4aW4iLCJpYXQiOjE1MzAxMDAyODAsImV4cCI6MTUzMDEwNzQ4MCwibmJmIjoxNTMwMTAwMjgwLCJqdGkiOiJSd2dRY1NzUTdBSXhra2lWIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.twxp1_P0QM4LGbT8tkcNuS10pc66H1VwFwUK1zLaDt0",
     *      "token_type": "Bearer",
     *      "expires_in": 7200
     *     }
     *
     * @apiUse  ValidationError
     */
    public function login(AuthorizationRequest $request)
    {
        $username = $request->user_name;
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['user_email'] = $username :
            $credentials['user_phone'] = $username;

        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            //            throw new ApiException(Utils::UserNotFound);
            return response()->json('用户名或密码错误');
        }
        return Utils::respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @api {post} /login/{sns_type} 第三方登录
     * @apiVersion       1.0.0
     * @apiDescription 第三方登录
     * @apiGroup accountGroup
     * @apiPermission    none
     *
     * @apiParam {String} code  code
     * @apiParam {String{weixin,miniprogram,qq,weibo}} sns_type 第三方类型
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 403 Not Found
     *     {
     *       "code": "UserNotFound",
     *       "message": "第三方类型错误"
     *     }
     *
     */
    public function snsLogin($sns_type, Request $request)
    {
        if (!in_array($sns_type, config('config.sns_type'))) {
            throw new ApiException(Utils::UserNotFound);
        }
        $user  = User::find(1);
        $token = Utils::getToken($user);
        return Utils::respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @api {put} /refresh 刷新token
     * @apiVersion       1.0.0
     * @apiDescription 刷新token
     * @apiGroup accountGroup
     * @apiPermission    token
     *
     * @apiUse InvalidToken
     */
    public function refresh()
    {
        $token = Auth::guard('api')->refresh();
        return Utils::respondWithToken($token);
    }

    /**
     * @api {delete} /logout 退出登录
     * @apiVersion       1.0.0
     * @apiDescription 退出登录
     * @apiGroup accountGroup
     * @apiPermission    token
     *
     * @apiUse InvalidToken
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json('success');
    }

    /**
     * @api {get} /me 获取用户信息
     * @apiVersion       1.0.0
     * @apiDescription 获取用户登录信息
     * @apiGroup accountGroup
     * @apiPermission    token
     *
     * @apiUse InvalidToken
     */
    public function me()
    {
        $user = Utils::getUser();
        $user['meta'] = [
            'access_token' => Auth::guard('api')->fromUser($user),
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ];
        return Utils::response($user);
    }

}


