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
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends ApiController
{

    /**
     * @api              {get} /index 接口测试
     * @apiVersion       1.0.0
     * @apiDescription   根据ID（id）获取列表信息
     * @apiGroup         accountGroup
     *
     * @apiParam {Number} id 任务ID
     * @apiParam {Number} [page] 页数
     * @apiParam {Number} [perpage] 每页的条数s
     *
     * @apiUse           InvalidToken
     */
    public function index ()
    {
        throw new ApiException(InvalidToken);
    }

    /**
     * @api               {post} /login 登录
     * @apiVersion        1.0.0
     * @apiDescription    账号密码登录
     * @apiGroup          accountGroup
     * @apiPermission     none
     *
     * @apiParam {String="邮箱","手机号"} user_name 账号
     * @apiParam {String{6..30}} password 密码
     *
     * @apiSuccess {String} access_token token
     * @apiSuccess {String} token_type 类型
     * @apiSuccess {Integer} expires_in 过期时间
     *
     * @apiParamExample {json} 请求示例
     * {
     *      "user_name" : "135512*****",
     *      "password" : "123456"
     * }
     *
     * @apiSuccessExample 正确响应:
     *     HTTP/1.1 200 OK
     *     {
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlkZXYubWNvby5tZVwvdjFcL2xvZ2luXC93ZWl4aW4iLCJpYXQiOjE1MzAxMDAyODAsImV4cCI6MTUzMDEwNzQ4MCwibmJmIjoxNTMwMTAwMjgwLCJqdGkiOiJSd2dRY1NzUTdBSXhra2lWIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.twxp1_P0QM4LGbT8tkcNuS10pc66H1VwFwUK1zLaDt0",
     *      "token_type": "Bearer",
     *      "expires_in": 7200
     *     }
     *
     * @apiUse            ValidationError
     * @apiErrorExample {json} InvalidAccountOrPassword:
     *     HTTP/1.1 404 Unprocessable Entity
     *     {
     *       "code": "InvalidAccountOrPassword",
     *       "message": "账号或密码错误"
     *     }
     *
     */
    public function login (AuthorizationRequest $request)
    {
        $username = $request->user_name;
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['user_email'] = $username :
            $credentials['user_phone'] = $username;

        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return jsonError(InvalidAccountOrPassword);
        }

        return jsonSuccess(Utils::respondWithToken($token), 201);
    }

    /**
     * @api              {post} /login/{sns_type} 第三方登录
     * @apiVersion       1.0.0
     * @apiDescription   第三方登录
     * @apiGroup         accountGroup
     * @apiPermission    none
     *
     * @apiParam {String} code  code
     * @apiParam {String="weixin","miniprogram","qq","weibo"}} sns_type 第三方类型
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "code": "SnsNotFound",
     *       "message": "第三方类型错误"
     *     }
     *
     * @apiSuccessExample 正确响应:
     *     HTTP/1.1 200 OK
     *     {
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlkZXYubWNvby5tZVwvdjFcL2xvZ2luXC93ZWl4aW4iLCJpYXQiOjE1MzAxMDAyODAsImV4cCI6MTUzMDEwNzQ4MCwibmJmIjoxNTMwMTAwMjgwLCJqdGkiOiJSd2dRY1NzUTdBSXhra2lWIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.twxp1_P0QM4LGbT8tkcNuS10pc66H1VwFwUK1zLaDt0",
     *      "token_type": "Bearer",
     *      "expires_in": 7200
     *     }
     *
     */
    public function snsLogin ($sns_type, Request $request)
    {
        if (!in_array($sns_type, config('config.sns_type'))) {
            return jsonError(SnsNotFound);
        }
        $user  = User::find(1);
        $token = Utils::getToken($user);
        return jsonSuccess(Utils::respondWithToken($token), 201);
    }

    /**
     * @api              {put} /refresh 刷新token
     * @apiVersion       1.0.0
     * @apiDescription   刷新token
     * @apiGroup         accountGroup
     * @apiPermission    token
     *
     * @apiUse           InvalidToken
     *
     * @apiSuccessExample 正确响应:
     *     HTTP/1.1 201 OK
     *     {
     *      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGlkZXYubWNvby5tZVwvdjFcL2xvZ2luXC93ZWl4aW4iLCJpYXQiOjE1MzAxMDAyODAsImV4cCI6MTUzMDEwNzQ4MCwibmJmIjoxNTMwMTAwMjgwLCJqdGkiOiJSd2dRY1NzUTdBSXhra2lWIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.twxp1_P0QM4LGbT8tkcNuS10pc66H1VwFwUK1zLaDt0",
     *      "token_type": "Bearer",
     *      "expires_in": 7200
     *     }
     *
     */
    public function refresh ()
    {
        $token = Auth::guard('api')->refresh();
        return jsonSuccess(Utils::respondWithToken($token), 201);
    }

    /**
     * @api              {delete} /logout 退出登录
     * @apiVersion       1.0.0
     * @apiDescription   退出登录
     * @apiGroup         accountGroup
     * @apiPermission    token
     *
     * @apiSuccessExample  正确响应:
     *     HTTP/1.1 204 No Content
     *
     */
    public function logout ()
    {
        try {
            Auth::guard('api')->logout();
        } catch (\Exception $e) {//退出登录异常不做任何处理
        }
        return JsonSuccess('success', 204);
    }

    /**
     * @api              {get} /me 获取用户信息
     * @apiVersion       1.0.0
     * @apiDescription   获取用户登录信息
     * @apiGroup         accountGroup
     * @apiPermission    token
     *
     * @apiUse           InvalidToken
     */
    public function me ()
    {
        if (!Utils::authCheck()) return jsonError(InvalidToken);
        $user = Utils::getUser();
        return JsonSuccess($user);
    }

}


