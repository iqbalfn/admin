<?php

/**
 * Get translation of string based on active language
 * @return string tranlation or the text it self
 */
function _l($str){
    $lang = lang($str);
    return $lang ? $lang : $str;
}