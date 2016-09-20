<?php

if(!defined('BASEPATH'))
    die;

class MY_Form_validation extends CI_Form_validation
{
    
    /**
     * Make sure the value is exists on table
     * @rules "in_table[table.field]
     */
    public function in_table($str, $rule){
        sscanf($rule, '%[^.].%[^.]', $table, $field);
        $ci =&get_instance();
        if(!$str)
            return TRUE;
        
        // model name
        $model = ucfirst(str_replace('_', '', $table));
        $model_name = $model . '_model';
        $ci->load->model($model_name, $model);
        
        $row = $ci->$model->getByCond([$field=>$str],1);
        if($row)
            return TRUE;
        return FALSE;
    }
    
    /**
     * Make sure the media file exists.
     * @rule 'media'
     * TODO Should we download the media?
     */
    public function media($str){
        // skip this if it point to different host
        if(substr($str, 0, 4) === 'http')
            return true;
        
        if(!strstr($str,',')){
            $abs = dirname(BASEPATH) . '/' . ltrim($str, '/');
            return is_file($abs);
        }
        
        $new_values = [];
        
        $strs = explode(',', $str);
        foreach($strs as $str){
            $str = trim($str);
            if(!$str)
                continue;
            $abs = dirname(BASEPATH) . '/' . ltrim($str, '/');
            if(is_file($abs))
                $new_values[] = $str;
        }
        
        if(!count($new_values))
            return false;
        return implode(',', $new_values);
    }
    
    /**
     * Make sure the value is unique or the value is belong to me.
     * @rule 'is_unique[table.field,url-segment-index]
     */
    public function is_unique($str, $field){
        if(!strstr($field, ','))
            return parent::is_unique($str, $field);
        
        $ci =&get_instance();
        
        $rule = explode(',', $field);
        $uri_segment = $rule[1];
        $table = explode('.', $rule[0]);
        $field = $table[1];
        $table = $table[0];
        
        // model name
        $model = ucfirst(str_replace('_', '', $table));
        $model_name = $model . '_model';
        $ci->load->model($model_name, $model);
        
        $row = $ci->$model->getBy($field, $str, 1);
        if(!$row)
            return true;
            
        if($uri_segment == 0){
            if($row->id == $ci->user->id)
                return true;
            return false;
        }
        if($row->id == $ci->uri->segment($uri_segment))
            return true;
        return false;
    }
}