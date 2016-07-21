<?php

if(!defined('BASEPATH'))
    die;

class Event extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function _schemaEvent($event){
        $schemas = array();
        
        $meta_title = $event->seo_title->clean();
        if(!$meta_title)
            $meta_title = $event->name->clean();
        
        $meta_description = $event->seo_description->clean();
        if(!$meta_description)
            $meta_description = $event->content->chars(160);
        
        if($event->seo_schema->value){
            $data = array(
                '@context'      => 'http://schema.org',
                '@type'         => $event->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'location'      => array(
                    '@type'         => 'Place',
                    'name'          => $event->name->clean(),
                    'address'       => $event->address
                ),
                'image'         => $event->cover,
                'url'           => base_url($event->page),
                'keywords'      => $event->seo_keywords,
                'startDate'     => $event->date->format('c'),
//                 'endDate'       => '...',
//                 'offers'        => '...',
//                 'performer'     => '...'
            );
            
            $schemas[] = $data;
        }
        
        $breadcs = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => base_url(),
                        'name' => $this->setting->item('site_name')
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => base_url('/#event'),
                        'name' => 'Event'
                    )
                )
            )
        );
        
        $schemas[] = $breadcs;
        return $schemas;
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
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $event = $this->Event->getBy('slug', $slug);
        if(!$event)
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $params = array();
        
        $event = $this->formatter->event($event, false, false);
        $event->schema = $this->_schemaEvent($event);
        $params['event'] = $event;
        
        $view = 'event/single';
        if($this->theme->exists('event/single-' . $event->slug))
            $view = 'event/single-' . $event->slug;
        
        $this->respond($view, $params);
    }
}