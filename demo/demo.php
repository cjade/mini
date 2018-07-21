<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/25
 * Time: 上午11:21
 */

ini_set('date.timezone', 'Asia/Shanghai');

class A
{
    public        $a;
    public static $b;

    function add ($a)
    {
        $this->a = $a;
        return $this;
    }

    function setA ()
    {
        $this->a = strtolower($this->a);
        return $this;
    }

    function getA ()
    {
        return $this->a;
    }

}

$a = new A();
echo $a->add('adADf')->setA()->getA();


