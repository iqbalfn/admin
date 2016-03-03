<?php

if(!defined('BASEPATH'))
    die;

class MY_Form_validation extends CI_Form_validation
{
    
    /**
     * Make sure the media file exists.
     * @rule 'media'
     * TODO Should we download the media?
     */
    public function media($str){
        // skip this if it point to different host
        if(substr($str, 0, 4) === 'http')
            return true;
        
        $abs = dirname(BASEPATH) . '/' . ltrim($str, '/');
        return is_file($abs);
    }
}