<?php

/**
 * Check if array key exists and return the value or alternative
 * @param string key The array key.
 * @param array array The array.
 * @param mixed alt The alternative to return if key not exists, default false.
 */
function array_key_value_or($key, $array, $alt=false){ 
    return array_key_exists($key, $array) ? $array[$key] : $alt;
}

/**
 * Group list of object by property
 * @param array list List of the object.
 * @param string prop The property to group by.
 * @return groupped object by $prop
 */
function group_by_prop($list, $prop='parent'){
    $result = array();
    foreach($list as $li){
        if(!array_key_exists($li->$prop, $result))
            $result[$li->$prop] = array();
        $result[$li->$prop][] = $li;
    }
    
    return $result;
}

/**
 * Group items per columns
 * @param array list List of object to group
 * @param integer column Total column / total item per group
 */
function group_per_column($list, $column=3){
    $result = array();
    
    $group = 0;
    foreach($list as $index => $item){
        if(!array_key_exists($group, $result))
            $result[$group] = array();
        $result[$group][$index] = $item;
        if(count($result[$group]) >= $column)
            $group++;
    }
    
    return $result;
}

/**
 * Set list object property as array key.
 * @param array list The indexed key based array
 * @param string key The property of subobject to set as parent key
 * @param string value Set the value taken from this property value, default false.
 * @return array The prop of sub-object is now the key of $list
 */
function prop_as_key($list, $key='id', $value=null){
    $result = array();
    
    foreach($list as $li => $obj){
        $val = $obj;
        if($value)
            $val = $val->$value;
        $result["{$obj->$key}"] = $val;
    }
    
    return $result;
}

/**
 * Get only property values of list of object
 * @param array list List of object.
 * @param string key The property name.
 * @return array List of property valeu.
 */
function prop_values($list, $key='id'){
    $result = array();
    
    foreach($list as $li => $obj)
        $result[] = $obj->$key;
    
    return $result;
}