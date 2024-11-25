<?php
/*
*'date_format' => 'M/d/Y',
*'date_format_javascript' => 'M/D/YYYY',
*/

if (!function_exists('pr')) {
    function pr($arg)
    {
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
    }
}
if (!function_exists('prx')) {
    function prx($arg)
    {
        echo '<pre>';
        print_r($arg);
        echo '</pre>';
        die('Developer mode .. !');
    }
}
if (!function_exists('dateFormat')) {
    function dateFormat()
    {
        return 'mm/dd/yy';
    }
}
if (!function_exists('phoneFormat')) {
    function phoneFormat($phone)
    {
        return "(" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6);
    }
}
