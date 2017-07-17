<?php
/**
 * Created by PhpStorm.
 * User: csi0n
 * Date: 7/17/17
 * Time: 4:11 PM
 */
if (!function_exists('dd')){
    function dd(){
        array_map(function ($x) {
            dump($x);
        }, func_get_args());
        die(1);
    }
}