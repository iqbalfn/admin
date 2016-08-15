<?php

class SiteBanner
{
    private $CI;
    private $ads = array();
    private $is_parsed = false;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    private function parseAds(){
        if($this->is_parsed)
            return;
        $this->is_parsed = true;
        
        $this->CI->load->model('Banner_model', 'Banner');
        $now = date('Y-m-d H:i:s');
        $banners = $this->CI->Banner->getByCond(['expired'=>(object)['>=', $now]], true);
        
        if($banners){
            foreach($banners as $ban){
                
                if(!$ban->code){
                    $tx = '<a href="' . $ban->link . '" target="_blank">';
                    $tx.= '<img src="' . $ban->media . '" alt="' . $ban->name . '" class="img-responsive">';
                    $tx.= '</a>';
                    $ban->code = $tx;
                }
                
                $this->ads[$ban->name] = $ban->code;
            }
        }
    }
    
    public function item($name){
        if(!$this->is_parsed)
            $this->parseAds();
        
        if(!array_key_exists($name, $this->ads))
            return '';
        return $this->ads[$name];
    }
}