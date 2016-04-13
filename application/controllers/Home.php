<?php

if(!defined('BASEPATH'))
    die;

class Home extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        $params = array(
            'title' => $this->setting->item('site_frontpage_title')
        );
        
        $this->respond('home', $params);
    }
}