<?php
/**
 * 配置文件
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/6/24
 * Time: 下午4:59
 */

return [
    'api_prefix'  => env('API_PREFIX', 'api'),//api域名前缀
    'domain'      => env('APP_URL'),//域名
    'api_version' => [ //接口版本
        'v1'
    ],
    'ClientTypes' => [  //允许的X-MC-Client-Type
        'miniprogram' => '小程序',
    ],
    'sns_type'    => [//第三方类型(1：微信；2：小程序；3：qq；4：微博)
        'weixin'      => 1,
        'miniprogram' => 2,
        'qq'          => 3,
        'weibo'       => 4
    ]
];