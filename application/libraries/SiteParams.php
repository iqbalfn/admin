<?php

class SiteParams
{
    private $CI;
    private $site_params;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    private function _parse(){
        if($this->site_params)
            return;
        
        $site_params = $this->CI->cache->file->get('site_params');
        if(!$site_params || is_dev()){
            $this->CI->load->model('Siteparams_model', 'Siteparams');
            $site_params = $this->CI->Siteparams->getByCond([], true);
            if($site_params)
                $site_params = prop_as_key($site_params, 'name', 'value');
            $this->CI->cache->file->save('site_params', $site_params, 604800);
        }
        
        if(!$site_params)
            $site_params = array();
        $this->site_params = $site_params;
    }
    
    /**
     * Get/Set the site params
     * @param string name The site params name.
     * @param mixed value The new value of the params.
     * @return mixed site params value.
     */
    public function item($name, $value=null){
        $this->_parse();
        
        if(!is_null($value))
            $this->site_params[$name] = $value;
        if(array_key_exists($name, $this->site_params))
            return $this->site_params[$name];
        return false;
    }
}