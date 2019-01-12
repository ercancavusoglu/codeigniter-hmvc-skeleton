<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('clear_string'))
{
    function clear_string($string) {
        return trim(addslashes(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($string)))));
    }
}

if ( ! function_exists('clear_non_alpha'))
{
    function clear_non_alpha($string) {
        return preg_replace("/[^a-zA-ZöçşiğüÖÇŞİĞÜ]/", "", $string);
    }
}

if ( ! function_exists('tr_strtolower'))
{
    function tr_strtolower($str) {
        $str = str_replace(array('İ', 'I'), array('i', 'ı'), $str);
        return mb_strtolower($str);
    }
}

if ( ! function_exists('tr_strtoupper'))
{
    function tr_strtoupper($str) {
        $str = str_replace(array('i', 'ı'), array('İ', 'I'), $str);
        return mb_strtoupper($str);
    }
}

if ( ! function_exists('count_format'))
{
    function count_format($num) {
        return number_format($num, 0, '', '.');
    }
}

if ( ! function_exists('price_format'))
{
    function price_format($num) {
        return number_format($num, 2, ',', '.');
    }
}