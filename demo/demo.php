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

class Superman{
    protected $power;
    public function __construct ()
    {
        $this->power = new Power(999,100);
    }
}