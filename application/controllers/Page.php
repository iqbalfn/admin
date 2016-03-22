<?php

if(!defined('BASEPATH'))
    die;

class Page extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Page_model', 'Page');
        $page = $this->Page->getBy('slug', $slug);
        if(!$page)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $params['page'] = $this->formatter->page($page, false, false);
        
        $view = 'page/single';
        if($this->theme->exists('page/single-' . $page->slug))
            $view = 'page/single-' . $page->slug;
        
        $this->respond($view, $params);
    }
}