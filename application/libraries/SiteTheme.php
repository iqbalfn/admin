<?php

class SiteTheme
{
    private $CI;
    private $theme;
    
    function __construct(){
        $this->CI =&get_instance();
        
        $theme = $this->CI->setting->item('site_theme');
        if($this->CI->uri->segment(1) == 'admin')
            $theme = 'admin';
        $this->theme = trim($theme, '/') . '/';
    }
    
    /**
     * Get current used theme.
     * @param string name The view name to append to the current theme name.
     * @return string current theme, optionally with suffix $name.
     */
    public function current($name=''){
        return $this->theme . ltrim($name, '/');
    }
    
    /**
     * Load the theme file based on current active theme.
     * @param string name The view name.
     * @param array params List of var-value pair of data to send to view.
     * @return string the view html content
     */
    public function file($name, $params=null){
        return $this->load($name, $params, true);
    }
    
    /**
     * Load the theme view
     * @param string name The view name.
     * @param array params List of var-value data to send to view.
     * @param boolean return Return the HTML instead of print it to output buffer.
     * @return string html on $return, void otherwise.
     */
    public function load($name, $params=null, $return=false){
        $theme = $this->current($name);
        
        return $this->CI->load->view($theme, $params, $return);
    }
    
    /**
     * Get absolute path to theme static file.
     * @param string name The theme static file name.
     * @param boolean version Add versioning on production system.
     * @return string absolute path to theme static file.
     */
    public function static($file){
        if(!is_dev())
            $file = preg_replace('!\.([a-z]+)$!','.min.$1', $file);
        
        return base_url('theme/' . $this->current($file));
    }
}