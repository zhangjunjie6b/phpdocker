<?php
/**
 * Created by PhpStorm.
 * User: zhangjunjie
 * Date: 2019/2/18
 * Time: 6:02 PM
 */


$start = convert(memory_get_usage(true));

echo $start.PHP_EOL;

range(1, 1000000);

$array = array();

/*for($i = 0; $i<1000000; $i++) {
    $array[$i] = null;
}*/

$end = convert(memory_get_usage(true));

echo $end.PHP_EOL;




function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
