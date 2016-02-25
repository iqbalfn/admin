<?php

class objEnum implements JsonSerializable
{
    public $value;
    public $label;
    
    function __construct($group, $value){
        $this->value = $value;
        $this->label = get_instance()->enum->item($group, $value);
        if(!$this->label)
            $this->label = '';
    }
    
    function __toString(){
        return $this->label;
    }
    
    function jsonSerialize(){
        return $this->label;
    }
}