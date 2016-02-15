<?php

class SiteEnum
{
    private $CI;
    private $system_enum;
    
    function __construct(){
        $this->CI =&get_instance();
        
        $system_enum = $this->CI->cache->file->get('system-enum');
        if(!$system_enum || is_dev()){
            $this->CI->load->model('Enum_model', 'Enum');
            $system_enum = $this->CI->Enum->getByCond([], true, false, ['id'=>'ASC']);
            if($system_enum){
                $system_enum = group_by_prop($system_enum, 'group');
                foreach($system_enum as $group => $values)
                    $system_enum[$group] = prop_as_key($values, 'value', 'label');
            }
            $this->CI->cache->file->save('system-enum', $system_enum, 604800);
        }
        
        $this->system_enum = $system_enum;
    }
    
    /**
     * Get/Set enum value
     * @param string group The enum group name.
     * @param mixed value The enum value, for database and query. Required for getting enum label or setter.
     * @param string label The enum label, for user. Required for setter only.
     * @return array if value and label is null, string if at value or label is not null.
     */
    public function item($group, $value=null, $label=null){
        if($label){
            if(!array_key_exists($group, $this->system_enum))
                $this->system_enum[$group] = array();
            $this->system_enum[$group][$value] = $label;
        }
        
        if(is_null($value)){
            if(array_key_exists($group, $this->system_enum))
                return $this->system_enum[$group];
            return false;
        }
        
        if(is_null($label)){
            if(!array_key_exists($group, $this->system_enum))
                return false;
            if(array_key_exists($value, $this->system_enum[$group]))
                return $this->system_enum[$group][$value];
            return false;
        }
        
        return $label;
    }
}