<?php

if(!defined('BASEPATH'))
    die;

class Gallery extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function feed(){
        $pages = array();
        $last_update = 0;
        
        $two_days_ago = new DateTime();
        $two_days_ago->sub(new DateInterval('P2D'));
        $two_days_ago = $two_days_ago->format('Y-m-d');
        
        $this->load->model('Gallery_model', 'Gallery');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        // GALLERIES
        $cond = array(
            'created' => (object)['>', $two_days_ago]
        );
        $galleries = $this->Gallery->getByCond($cond, true);
        if($galleries){
            $galleries = $this->formatter->gallery($galleries, false, false);
            foreach($galleries as $gallery){
                $pages[] = (object)array(
                    'page' => base_url($gallery->page),
                    'description' => $gallery->seo_description->value ? $gallery->seo_description : $gallery->description->chars(160),
                    'title' => $gallery->name,
                    'categories' => []
                );
                if($gallery->created->time > $last_update)
                    $last_update = $gallery->created->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url('/gallery/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; Gallery';
        $params['feed_owner_url'] = base_url();
        $params['feed_description'] = $this->setting->item('site_frontpage_description');
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
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