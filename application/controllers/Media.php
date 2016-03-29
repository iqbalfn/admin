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
    
    /**
     * Resize image to another size.
     */
    public function resize($dir1, $dir2, $dir3, $file){
        $width = null;
        $height= null;
        $ext   = 'jpg';
        $name  = null;
        
        if(preg_match('!(.+)_([0-9]*)x([0-9]*)\.([a-zA-Z]+)!', $file, $m)){
            $name  = $m[1];
            $width = $m[2];
            $height= $m[3];
            $ext   = $m[4];
        }
        
        if(!$width && !$height)
            return $this->show_404();
        
        $file_original = dirname(BASEPATH) . "/media/$dir1/$dir2/$dir3/$name.$ext";
        $file_requested= dirname(BASEPATH) . "/media/$dir1/$dir2/$dir3/$file";
        
        $this->load->library('MediaFile', '', 'media');
        if(!$this->media->resizeImage($file_original, $file_requested, $width, $height))
            return $this->show_404();
        
        $this->load->helper('file');
        $content = file_get_contents($file_requested);
        $mime = get_mime_by_extension($file_requested);
        
        $this->output
            ->set_status_header(200)
            ->set_content_type($mime)
            ->set_output($content)
            ->_display();
        exit;
    }
}