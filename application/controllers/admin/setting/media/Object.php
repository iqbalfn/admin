<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function execute(){
        if(!$this->user)
            return $this->ajax(false, 'Not authorized');
        if(!$this->can_i('delete-media_sizes'))
            return $this->ajax(false, 'Not authorized');
        
        $folder = trim($this->input->post('folder'), '/');
        
        $folder_test = explode('/', $folder);
        if($folder_test[0] != 'media')
            return $this->ajax(false, 'Access directory forbidden');
        
        $target = dirname(BASEPATH) . '/' . $folder;
        
        if(!is_dir($target))
            return $this->ajax('success', false);
        
        $files = array_diff(scandir($target), ['.','..','.gitkeep','.htaccess','index.html']);
        if(!$files)
            return $this->ajax('success', false);
        
        $cleaned_files = [];
        foreach($files as $file){
            if(!preg_match('!_([x0-9]+)\.([a-zA-Z]+)!', $file))
                continue;
            
            $target_file = $target . '/' . $file;
            if(is_file($target_file))
                unlink($target_file);
        }
        
        $this->event->media->cleared(null);
        $this->ajax('success', false);
    }
    
    public function clear(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-media_sizes'))
            return $this->show_404();
        
        $total = 0;
        
        $media_path = dirname(BASEPATH) . '/media';
        $skip_files = ['.','..','index.html','.gitkeep','.htaccess'];
        $files = array_diff(scandir($media_path), $skip_files);
        $folders = [];
        
        foreach($files as $file){
            $subfiles = array_diff(scandir($media_path . '/' . $file), $skip_files);
            foreach($subfiles as $subfile){
                $subsubfiles = array_diff(scandir($media_path . '/' . $file . '/' . $subfile), $skip_files);
                foreach($subsubfiles as $subsubfile){
                    $folders[] = '/media/' . $file . '/' . $subfile . '/' . $subsubfile;
                    $total++;
                }
            }
        }
        
        $params = array(
            'title' => _l('Clear Media Sizes'),
            'total' => $total,
            'folders' => $folders
        );
        
        $this->respond('setting/media/index', $params);
    }
    
}