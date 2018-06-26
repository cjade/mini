<?php
/**
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
use App\Service\SnsUser as SNS;

class AuthController extends ApiController
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @api {get} /test 接口测试
     * @apiDescription 根据ID（id）获取列表信息
     * @apiGroup accesss
     *
     * @apiParam {Number} id 任务ID
     * @apiParam {Number} [page] 页数
     * @apiParam {Number} [perpage] 每页的条数s
     *
     * @apiUse UserNotFoundError
     */
    public function index()
    {
        $aa = Hash::make('123456');
        return $aa;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthorizationRequest $request)
    {
        $username = $request->user_name;
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['user_email'] = $username :
            $credentials['user_phone'] = $username;

        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json('用户名或密码错误');
        }


        return SNS::respondWithToken($token)->setStatusCode(201);
    }

    /**
     * @api {post} /login/{sns_type} 第三方登录
     * @apiDescription 第三方登录
     * @apiGroup access
     *
     * @apiParam {String} sns_type 第三方类型
     *
     * @param Request $request
     * @return $this
     */
    public function snsLogin($sns_type, Request $request)
    {
        $user = User::find(1);
        $token = Auth::guard('api')->fromUser($user);
        return SNS::respondWithToken($token)->setStatusCode(201);
    }

}


