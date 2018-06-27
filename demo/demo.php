<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/25
 * Time: 上午11:21
 */

$str =  'dsd ds ds';
echo filter_var($str,FILTER_CALLBACK,['options'=> function() use($str) {
    return str_replace(" ", "_", $str);
}]);