<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:49
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

}

/**
 * ============================================================================
 * 公共部分定义-api模块分组
 * ============================================================================
 */


/**
 * @apiDefine accountGroup 帐号相关
 * 用户登录、注册、登出、第三方绑定、获取用户信息等
 *
 */


/**
 * ============================================================================
 * 公共部分定义-权限（apiPermission）
 * ============================================================================
 */

/**
 * @apiDefine token 需要用户登录授权
 * 需要在header中传递Authorization，详情参考“使用前必读”-“公共参数”
 *
 */

/**
 * @apiDefine UserNotFoundError
 *
 * @apiError UserNotFound The id of the User was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "UserNotFound"
 *     }
 */