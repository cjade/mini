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
 * 需要在header中传递Authorization，"Bearer {access_token}"
 *
 */

/**
 * @apiDefine none 无需登录授权
 * 无需登录授权
 *
 */

/**
 * ============================================================================
 * 公共部分定义-状态码分组（apiSuccess、apiError）
 * ============================================================================
 */

/**
 * @apiDefine 200 成功 200 OK
 * 获取资源成功、修改资源成功
 *
 */

/**
 * @apiDefine 201 成功 201 Created
 * 新建资源成功
 *
 */

/**
 * @apiDefine 204 成功 204 No Content
 * 删除资源成功
 *
 */

/**
 * @apiDefine 4xx 错误 4xx
 * 错误
 *
 */


/**
 * ============================================================================
 * 公共部分定义-错误响应（apiError、apiErrorExample）
 * ============================================================================
 */

/**
 * @apiDefine InvalidToken
 *
 * @apiError (4xx) InvalidToken 未登录或授权过期，请登录
 *
 * @apiErrorExample {json} InvalidToken:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "code": "InvalidToken",
 *       "message": "未登录或授权过期，请登录"
 *     }
 */

/**
 * @apiDefine ValidationError
 *
 * @apiError (4xx) ValidationError 输入字段验证出错，缺少字段或字段格式有误（详见message）
 *
 * @apiErrorExample {json} ValidationError:
 *     HTTP/1.1 422 Unprocessable Entity
 *     {
 *       "code": "ValidationError",
 *       "message": "输入字段验证出错，缺少字段或字段格式有误"
 *     }
 */

/**
 * @apiDefine AccountNotExist
 *
 * @apiError (4xx) AccountNotExist 帐号名不存在
 *
 * @apiErrorExample {json} AccountNotExist:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "code": "AccountNotExist",
 *       "message": "帐号名不存在"
 *     }
 */

/**
 * @apiDefine InvalidPassword
 *
 * @apiError (4xx) InvalidPassword 密码错误
 *
 * @apiErrorExample {json} InvalidPassword:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "code": "InvalidPassword",
 *       "message": "密码错误"
 *     }
 */

/**
 * @apiDefine NotFound
 *
 * @apiError (4xx) NotFound 请求的资源不存在（详见message）
 *
 * @apiErrorExample {json} NotFound:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "code": "NotFound",
 *       "message": "请求的资源不存在"
 *     }
 */

/**
 * @apiDefine AccountHasExist
 *
 * @apiError (4xx) AccountHasExist 帐号名已经存在
 *
 * @apiErrorExample {json} AccountHasExist:
 *     HTTP/1.1 409 Conflict
 *     {
 *       "code": "AccountHasExist",
 *       "message": "帐号名已经存在"
 *     }
 */
