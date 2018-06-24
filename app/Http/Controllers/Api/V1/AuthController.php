<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:48
 */


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController
{
    /**
     * * @api {get} /test 接口测试
     * @apiDescription 根据ID（id）获取列表信息
     * @apiGroup accesss
     *
     * @apiParam {Number} id 任务ID
     * @apiParam {Number} [page] 页数
     * @apiParam {Number} [perpage] 每页的条数s
     *
     * @apiUse UserNotFoundError
     */
    public function index(){
        session('index','asd');
        return session()->getId();
    }

    public function index1(){
        $aa = session('index');
        dd($aa);
        return $aa;
    }
}


