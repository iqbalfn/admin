<?php

if(!defined('BASEPATH'))
    die;

class Home extends SITE_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        $this->load->model('User_model', 'User');
        
    }
}