<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/25
 * Time: 上午11:21
 */

class Power
{
    /**
     * @var 能力值
     */
    protected $ability;

    /**
     * @var 能力范围
     */
    protected $range;

    public function __construct ($ability, $range)
    {
        $this->ability = $ability;
        $this->range   = $range;
    }
}

class Superman
{
    protected $power;

    public function __construct ()
    {
        $this->power = new Power(999, 100);
    }
}

$data = [
    [
        'order_id' => 1,
        'user_id'  => 1,
    ], [
        'order_id' => 2,
        'user_id'  => 2,
    ]
];

$res = [
    [
        'order_id' => 1,
        'user_id'  => 1,
    ], [
        'order_id' => 2,
        'user_id'  => 2,
    ]
];
$qq  = array(
    3187 => '3873464',
    3188 => '3873465',
    3189 => '3873472',
    3190 => '3873473',
    3191 => '3873481',
    3192 => '3873482',
);
$dd = array();
$aa  = [1, 2, 3];
$bb  = [12, 1];
var_export(strtotime(date("Y-m-d",strtotime("-1 day"))));