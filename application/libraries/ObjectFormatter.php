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
     * @param array|boolean fetch List of field to format/force fetch the data from
     *  database for format type start with @.
     * @return formatted object.
     */
    public function format($name, $objects, $arraykey=false, $fetch=true){
        $current_user = $this->CI->user ? $this->CI->user->id : 0;
        
        if(!$objects)
            return $objects;
        
        if($arraykey === true)
            $arraykey = 'id';
        
        $single = is_object($objects);
        
        $rules = config_item('object_formatter');
        if(!array_key_exists($name, $rules)){
            if($arraykey && !$single)
                return prop_as_key($objects, $arraykey);
            return $objects;
        }
        
        if($single)
            $objects = [$objects];
        
        $rules = $rules[$name];
        $other_tables = array();
        
        if($fetch){
            if(is_string($fetch))
                $fetch = [$fetch];
            
            if(is_int($fetch))
                $fetch = true;
            
            if($fetch === true){
                $fetch = array();
                foreach($rules as $field => $rule)
                    $fetch[$field] = false;
            }
            
            $new_fetch = array();
            foreach($fetch as $field => $cond){
                if(is_numeric($field)){
                    unset($fetch[$field]);
                    $field = $cond;
                    $cond = false;
                    $fetch[$field] = $cond;
                }
                
                if(preg_match('!^@([a-z]+)\[([^\]]+)\]$!', $rules[$field], $match)){
                    $new_fetch[$field] = $cond;
                    $type = $match[1];
                    $table= $match[2];
                    
                    $other_tables[$field] = array(
                        'type' => $type,
                        'table'=> $table,
                        'rows' => array()
                    );
                }
            }
            $fetch = $new_fetch;
            
            if($other_tables){
                foreach($other_tables as $field => $cond){
                    $table_ids = array();
                    $type = $cond['type'];
                    $table = $cond['table'];
                    
                    foreach($objects as $obj){
                        if(in_array($type, array('chain', 'member')))
                            $table_ids[] = $obj->id;
                        elseif($type == 'parent')
                            $table_ids[] = $obj->$field;
                    }
                    $table_ids = array_unique($table_ids);
                    
                    if($type == 'parent'){
                        $dbrows = $this->CI->db
                            ->where_in('id', $table_ids)
                            ->get($table);
                        
                        if($dbrows->num_rows()){
                            $dbrows = $dbrows->result();
                            $dbrows = $this->format($table, $dbrows, 'id', $fetch[$field]);
                            $other_tables[$field]['rows'] = $dbrows;
                        }
                    
                    }elseif($type == 'member'){
                        $dbrows = $this->CI->db 
                            ->where_in($name, $table_ids)
                            ->where('user', $current_user)
                            ->get($table);
                        
                        if($dbrows->num_rows()){
                            $dbrows = $dbrows->result();
                            $dbrows = prop_as_key($dbrows, $name);
                            $other_tables[$field]['rows'] = $dbrows;
                        }
                    
                    }elseif($type == 'chain'){
                        $dbrows = $this->CI->db 
                            ->where_in($name, $table_ids)
                            ->get($table . '_chain');
                        
                        if($dbrows->num_rows()){
                            $dbrows = $dbrows->result();
                            $chain_ids = prop_values($dbrows, $table);
                            $chain_ids = array_unique($chain_ids);
                            
                            $chain_values = $this->CI->db 
                                ->where_in('id', $chain_ids)
                                ->get($table);
                            
                            if($chain_values->num_rows()){
                                $chain_values = $chain_values->result();
                                $chain_values = $this->format($table, $chain_values, 'id', $fetch[$field]);
                                
                                $dbrows_result = array();
                                foreach($dbrows as $row){
                                    $chain_value_id = $row->$table;
                                    if(!array_key_exists($chain_value_id, $chain_values))
                                        continue;
                                    $chain_value = clone $chain_values[$chain_value_id];
                                    $chain_value->chain_id = $row->id;
                                    if(!array_key_exists($row->$name, $dbrows_result))
                                        $dbrows_result[$row->$name] = array();
                                    $dbrows_result[$row->$name][] = $chain_value;
                                }
                                
                                $other_tables[$field]['rows'] = $dbrows_result;
                            }
                        }
                    }
                }
            }
        }
        
        $falsy = array(0, '0', 'no', 'false', false, null);
        foreach($objects as $index => &$object){
            foreach($rules as $field => $cond){
                if(array_key_exists($field, $other_tables)){
                    $other_field = $other_tables[$field];
                    $rows = $other_field['rows'];
                    if(in_array($other_field['type'], array('chain', 'member')))
                        $rows_id = $object->id;
                    else
                        $rows_id = $object->$field;
                    
                    if(array_key_exists($rows_id, $rows))
                        $object->$field = $rows[$rows_id];
                
                }elseif(property_exists($object, $field)){
                    switch($cond){
                        case 'boolean':
                            $value = strtolower($object->$field);
                            $value = !in_array($value, $falsy, true);
                            $object->$field = $value;
                            break;
                        case 'date':
                            $object->$field = new objDate($object->$field);
                            break;
                        case 'delete':
                            unset($object->$field);
                            break;
                        case 'enum':
                            $object->$field = new objEnum("$name.$field", $object->$field);
                            break;
                        case 'integer':
                            $object->$field = (int)$object->$field;
                            break;
                        case 'media':
                            $object->$field = new objMedia($object->$field);
                            break;
                        case 'string':
                            $object->$field = (string)$object->$field;
                            break;
                        case 'text':
                            $object->$field = new objText($object->$field);
                            break;
                    }
                }else{
                    if(preg_match('!^join\(([^\)]+)\)$!', $cond, $match)){
                        $vars = explode('|', $match[1]);
                        $value = '';
                        foreach($vars as $var){
                            if(substr($var, 0, 1) == '$'){
                                $var = substr($var, 1);
                                if(property_exists($object, $var))
                                    $value.= $object->$var;
                            }else{
                                $value.= $var;
                            }
                        }
                        $object->$field = $value;
                    }
                }
            }
        }
        
        if($single)
            return $objects[0];
        if($arraykey)
            return prop_as_key($objects, $arraykey);
        return $objects;
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