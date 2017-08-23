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
        
        // download the image if the image is not there and it's not live site
        if(config_item('base_url') == 'https://merahputih.com/')
            return;
        
        $abs_file = dirname(BASEPATH) . $value;
        if(file_exists($abs_file))
            return;
        
        $xval = trim($value, '/');
        $xvals= explode('/', $xval);
        array_pop($xvals);
        $current_dir = dirname(BASEPATH) . '/';
        foreach($xvals as $dir){
            $current_dir.= $dir . '/';
            if(!is_dir($current_dir)){
                mkdir($current_dir);
                copy(APPPATH . 'index.html', $current_dir.'index.html');
            }
        }
        
        $live_version = 'https://merahputih.com' . $value;
        $cu = curl_init($live_version);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cu, CURLOPT_FOLLOWLOCATION, 1);
        $binary = curl_exec($cu);
        curl_close($cu);
        
        $f = fopen($abs_file, 'w');
        fwrite($f, $binary);
        fclose($f);
    }
    
    private function absURL($file=null){
        if(!$file)
            $file = $this->value;
        if(!$file)
            return '';
        
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