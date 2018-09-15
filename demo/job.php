<?php
/**
 * Created by PhpStorm.
 * User: Jade
 * Date: 2018/9/2
 * Time: 下午2:46
 */

class PHP_Job{
    public function perform()
    {
        $time = date('Y-m-d H:i:s',$this->args['time']);
        $test = $this->args['array']['test'];
        echo $time.PHP_EOL;
        echo $test.PHP_EOL;
    }
}