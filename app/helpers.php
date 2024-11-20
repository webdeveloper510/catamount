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
        return 'M-dd-Y';
    }
}
