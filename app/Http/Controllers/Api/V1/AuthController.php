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
use Illuminate\Support\Facades\Hash;
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
     * @apiUse UserNotFoundError
     */
    public function index()
    {
                    throw new ApiException(10001);
    }

    /**
     * @api {post} /login 登录
     * @apiVersion       1.0.0
     * @apiDescription 账号密码登录
     * @apiGroup accountGroup
     * @apiPermission    none
     *
     * @apiParam {String} user_name 账号
     * @apiParam {String} password 密码
     *
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
     * @apiParam {String} sns_type 第三方类型
     *
     */
    public function snsLogin($sns_type, Request $request)
    {
        $user  = User::find(1);
        $token = Auth::guard('api')->fromUser($user);
        return Utils::respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @api {put} /refresh 刷新token
     * @apiVersion       1.0.0
     * @apiDescription 刷新token
     * @apiGroup accountGroup
     * @apiPermission    token
     *
     *
     */
    public function refresh(){
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
     *
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json('success');
    }

    /**
     * @api {put} /me 获取用户信息
     * @apiVersion       1.0.0
     * @apiDescription 获取登录登录信息
     * @apiGroup accountGroup
     * @apiPermission    token
     *
     *
     */
    public function me(){
        $me = Auth::guard('api')->user();
        return response()->json($me);
    }

}


