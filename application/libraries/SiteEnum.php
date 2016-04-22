<?php

class SiteEnum
{
    private $CI;
    private $site_enum;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    private function _parse(){
        if($this->site_enum)
            return;
        
        $site_enum = $this->CI->cache->file->get('site_enum');
        if(!$site_enum || is_dev()){
            $this->CI->load->model('Siteenum_model', 'SEnum');
            $site_enum = $this->CI->SEnum->getByCond([], true, false, ['id'=>'ASC']);
            if($site_enum){
                $site_enum = group_by_prop($site_enum, 'group');
                foreach($site_enum as $group => $values)
                    $site_enum[$group] = prop_as_key($values, 'value', 'label');
            }
            $this->CI->cache->file->save('site_enum', $site_enum, 604800);
        }
        
        $this->site_enum = $site_enum;
    }
    
    /**
     * Get/Set enum value
     * @param string group The enum group name.
     * @param mixed value The enum value, for database and query. Required for getting enum label or setter.
     * @param string label The enum label, for user. Required for setter only.
     * @return array if value and label is null, string if at value or label is not null.
     */
    public function item($group, $value=null, $label=null){
        $this->_parse();
        
        if($label){
            if(!array_key_exists($group, $this->site_enum))
                $this->site_enum[$group] = array();
            $this->site_enum[$group][$value] = $label;
        }
        
        if(is_null($value)){
            if(array_key_exists($group, $this->site_enum))
                return $this->site_enum[$group];
            return false;
        }
        
        if(is_null($label)){
            if(!array_key_exists($group, $this->site_enum))
                return false;
            if(array_key_exists($value, $this->site_enum[$group]))
                return $this->site_enum[$group][$value];
            return false;
        }
        
        return $label;
    }
}