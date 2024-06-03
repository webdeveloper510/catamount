<?php


if(!function_exists('pr')) {
    function pr($arg){
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
    }
}
if(!function_exists('prx')) {
    function prx($arg){
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
        die('Developer mode .. !');
    }
}