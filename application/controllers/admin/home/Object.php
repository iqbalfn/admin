<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login');
        if(!$this->can_i('read-admin_page'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Admin')
        );
        
        $this->respond('home/index', $params);
    }
}