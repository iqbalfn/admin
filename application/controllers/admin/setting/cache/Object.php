<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function clear(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-cache'))
            return $this->show_404();
        
        $files = array_diff(scandir(APPPATH . 'cache'), ['.', '..', '.htaccess', 'index.html']);
        foreach($files as $file){
            $file_path = APPPATH . 'cache/' . $file;
            if(is_file($file_path))
                unlink($file_path);
        }
        
        $params = array(
            'title' => _l('Clear Cache'),
            'caches' => $files
        );
        
        $this->event->cache->cleared(null);
        $this->respond('setting/cache/index', $params);
    }
    
}