<?php

if(!defined('BASEPATH'))
    die;

class objText implements JsonSerializable
{
    public $value;
    private $clean;
    
    function __construct($text){
        $this->value = (string)$text;
        
    }
    
    public function chars($len=20){
        $ctx = $this->clean();
        return trim(substr($ctx, 0, $len), ' &');
    }
    
    public function clean(){
        if($this->clean)
            return $this->clean;
        
        $ctx = preg_replace('!<[^>]+>!', ' ', $this->value);
        $ctx = preg_replace('! +!', ' ', $ctx);
        $ctx = trim(htmlspecialchars($ctx, ENT_QUOTES));
        
        $this->clean = $ctx;
        
        return $ctx;
    }
    
    public function words($len){
        $ctx = $this->clean();
        $ctxs= explode(' ', $ctx);
        $ctx = array_slice($ctxs, 0, $len);
        return implode(' ', $ctx);
    }
    
    public function safe(){
        return htmlspecialchars($this->value, ENT_QUOTES);
    }
    
    function __toString(){
        return $this->value;
    }
    
    function jsonSerialize(){
        return $this->value;
    }
}