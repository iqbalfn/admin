<?php

if(!defined('BASEPATH'))
    die;

class objMedia implements JsonSerializable
{
    public $value;
    public $hotlinking;
    
    function __construct($value){
        $this->value = $value;
        if(substr($value, 0, 4) == 'http')
            $this->hotlinking = true;
    }
    
    private function absURL($file=null){
        if(!$file)
            $file = $this->value;
        
        if($this->hotlinking)
            return $file;
        
        $base_url = ci()->setting->item('media_host');
        
        if($base_url)
            return chop($base_url, ' /') . '/' . ltrim($file, ' /');
        return base_url($file);
    }
    
    function __get($prop){
        if($this->hotlinking)
            return $this->value;
        
        $exts = explode('.', $this->value);
        $ext  = end($exts);
        
        if(!in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'bpm')))
            return $this->absURL($this->value);
        
        $file = preg_replace('/\.' . $ext . '$/', ($prop . '.' . $ext), $this->value);
        
        return $this->absURL($file);
    }
    
    function __toString(){
        return $this->absURL();
    }
    
    function jsonSerialize(){
        return $this->absURL();
    }
}