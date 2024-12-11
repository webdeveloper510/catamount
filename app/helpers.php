<?php
/*
*'date_format' => 'M/d/Y',
*'date_format_javascript' => 'M/D/YYYY',
*/

use Carbon\Carbon;

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
if (!function_exists('carbonDateFormat')) {
    function carbonDateFormat($date)
    {
        $date = new DateTimeImmutable($date);
        $formattedDate = $date->format('Y-m-d');
        return $formattedDate;
        // return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }
}
if (!function_exists('dateFormat_blade')) {
    function dateFormat_blade($date)
    {
        $date = new DateTimeImmutable($date);
        $formattedDate = $date->format('m/d/Y');
        return $formattedDate;
        // return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    }
}
