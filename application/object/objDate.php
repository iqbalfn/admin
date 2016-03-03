<?php

if(!defined('BASEPATH'))
    die;

class objDate implements JsonSerializable
{
    public $time;
    public $value;
    
    function __construct($date){
        $this->time = strtotime($date);
        $this->value = $date;
    }
    
    public function format($format){
        return date($format, $this->time);
        
    }
    
    function __toString(){
        return $this->value;
        
    }
    
    function jsonSerialize(){
        return $this->value;
    }
}