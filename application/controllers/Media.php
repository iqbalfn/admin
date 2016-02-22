<?php

if(!defined('BASEPATH'))
    die;

class Media extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    /**
     * File upload
     */
    public function upload(){
        if(!$this->user)
            return $this->ajax(null, 'Not authorized');
        
        $type = $this->input->post('type');
        if(!$type)
            return $this->ajax(null, 'Media type not provided');
        
        $name = $this->input->post('name');
        if(!$name)
            return $this->ajax(null, 'Media name not provided');
        
        $object = $this->input->post('object');
        
        $this->load->library('MediaFile', '', 'media');
        $data = $this->media->processUpload('file', $name, $type, $object);
        
        if(is_string($data))
            return $this->ajax(false, $data);
        
        $result = array(
            'id' => $data['media_id'],
            'original_name' => $data['original_name'],
            'media_file' => $data['local_media_file'],
            'media_folder' => $data['local_media_folder'],
            'file_ext' => $data['local_file_ext'],
            'file' => $data['local_file'],
            'file_name' => $data['local_file_name']
        );
        $this->ajax($result);
    }
}