<?php

if(!defined('BASEPATH'))
    die;

class Event extends MY_Controller
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
        
        $this->load->model('Event_model', 'Event');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $cond = array(
            'created' => (object)['>', $two_days_ago]
        );
        $events = $this->Event->getByCond($cond, true);
        if($events){
            $events = $this->formatter->event($events, false, false);
            foreach($events as $event){
                $pages[] = (object)array(
                    'page' => base_url($event->page),
                    'description' => $event->seo_description->value ? $event->seo_description : $event->content->chars(160),
                    'title' => $event->name,
                    'categories' => []
                );
                if($event->created->time > $last_update)
                    $last_update = $event->created->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url('/event/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; Event';
        $params['feed_owner_url'] = base_url();
        $params['feed_description'] = $this->setting->item('site_frontpage_description');
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Event_model', 'Event');
        $event = $this->Event->getBy('slug', $slug);
        if(!$event)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $params['event'] = $this->formatter->event($event, false, false);
        
        $view = 'event/single';
        if($this->theme->exists('event/single-' . $event->slug))
            $view = 'event/single-' . $event->slug;
        
        $this->respond($view, $params);
    }
}