<?php

if(!defined('BASEPATH'))
    die;

class Gallery extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Gallery_model', 'Gallery');
        $this->load->model('Gallerymedia_model', 'GMedia');
        $gallery = $this->Gallery->getBy('slug', $slug);
        if(!$gallery)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $params['gallery'] = $this->formatter->gallery($gallery, false, false);
        
        $media = $this->GMedia->getBy('gallery', $gallery->id, true);
        if($media)
            $media = $this->formatter->gallery_media($media, false, false);
        $gallery->media = $media;
        
        $view = 'gallery/single';
        if($this->theme->exists('gallery/single-' . $gallery->slug))
            $view = 'gallery/single-' . $gallery->slug;
        
        $this->respond($view, $params);
    }
}