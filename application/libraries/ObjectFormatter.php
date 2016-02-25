<?php

if(!defined('BASEPATH'))
    die;

class ObjectFormatter 
{
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
        $this->CI->load->config('object_formatter');
        
        $x_objs = ['objDate', 'objEnum', 'objMedia', 'objText'];
        foreach($x_objs as $obj)
            require_once(APPPATH . 'object/' . $obj . '.php');
    }
    
    /**
     * Start formatting the object.
     * @param string name The format name.
     * @param object|array objects Single object or list of object to format.
     * @param boolean arraykey Set field as the array key. Default false. True for id.
     * @param array|boolean condition List of field to format/force fetch the data from
     *  database for format type start with @.
     * @return formatted object.
     */
    public function format($name, $objects, $arraykey=false, $condition=true){
        
    }
    
    /**
     * MAGIC method to call _format
     * @param string name The format name.
     * @param array args List of arguments
     * @return as of format()
     */
    public function __call($name, $args){
        array_unshift($args, $name);
        return call_user_func_array(array($this, 'format'), $args);
    }
}