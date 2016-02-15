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
    }
}