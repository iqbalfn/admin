<?php

class ActionEvent
{
    private $CI;
    
    private $objects = array();
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    public function setUpdated($object){
        $ufile = dirname(BASEPATH) . '/update.json';
        
        $ujson = file_get_contents($ufile);
        
        $ujson = json_decode($ujson, true);
        $ujson[$object] = time();
        $ujson = json_encode($ujson);
        
        $f = fopen($ufile, 'w');
        fwrite($f, $ujson);
        fclose($f);
    }
    
    public function __get($object){
        $this->setUpdated($object);
        
        if(array_key_exists($object, $this->objects))
            return $this->objects[$object];
        return ( $this->objects[$object] = new ActionEventMethods($object) );
    }
}

class ActionEventMethods
{
    private $CI;
    private $object;
    
    function __construct($object){
        $this->CI =&get_instance();
        $this->object = $object;
        
        $file = dirname(BASEPATH) . '/application/events/' . $object . '.php';
        if(is_file($file))
            require_once($file);
    }
    
    public function __call($event, $args){
        $fn = 'event_' . $this->object . '_' . $event;
        if(function_exists($fn))
            return call_user_func_array($fn, $args);
    }
}