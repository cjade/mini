<?php
/**
 * 公共方法
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/28
 * Time: 上午9:18
 */


/**
 * ============================================================================
 * 公共部分定义-错误码信息
 * ============================================================================
 */

const InvalidToken             = 'InvalidToken';    //未登录，请登录
const Unauthorized             = 'Unauthorized';    // 授权过期，请登录
const ValidationError          = 'ValidationError'; //输入字段验证出错
const InvalidAccountOrPassword = 'InvalidAccountOrPassword';    //账号或密码错误
const NotFound                 = 'NotFound';    //请求的资源不存在
const SnsNotFound              = 'SnsNotFound';    //请求的第三方类型不存在
const AccountNotExist          = 'AccountNotExist';    //账号不存在

define('APP',['code'=>'InvalidToken','message'=>'未登录，请登录','statusCode'=>401]);

if (!function_exists('jsonSuccess')) {
    /**
     * 返回json数据
     * @param     $data       数据
     * @param int $statusCode http状态码
     * @return $this
     */
    function jsonSuccess ($data, $statusCode = 200)
    {
        return response()->json($data)->setStatusCode($statusCode)->header('Content-Type', 'application/json');
    }
}

if (!function_exists('JsonError')) {
    /**
     * 返回json错误信息
     * @param $body    数据
     * @param $code    状态码
     * @param $message 错误信息
     * @return $this
     */
    function JsonError ($code, $message = '', $body = '')
    {
        $codeArr = [
            'InvalidToken' => ['未登录，请登录', 401],
            'Unauthorized' => ['授权过期，请登录', 401],

            'InvalidAccountOrPassword' => ['账号或密码错误', 404],
            'ValidationError'          => ['输入字段验证出错', 422],
            'NotFound'                 => ['请求的资源不存在', 404],
            'SnsNotFound'              => ['第三方类型不存在', 400],
            'AccountNotExist'          => ['账号不存在', 404],
        ];

        if (array_key_exists($code, $codeArr)) {
            $statusCode = $codeArr[$code][1];
            $message    = empty($message) ? $codeArr[$code][0] : $message;
        } else {
            $statusCode = 500;
            $code       = 'UnknowError';
            $message    = '未知错误，请稍后再试';
        }

        $result['code']    = $code;
        $result['message'] = $message;
        if (!empty($body)) {
            $result['body'] = $body;
        }
        return response()->json($result)->setStatusCode($statusCode)->header('Content-Type', 'application/json');
    }
}