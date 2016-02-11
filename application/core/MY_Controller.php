<?php

if(!defined('BASEPATH'))
    die;

class MY_Controller extends CI_Controller
{
    public $user;
    public $session;
    
    function __construct(){
        parent::__construct();
        
    }
}

class SITE_Controller extends MY_Controller
{
    
    function __construct(){
        parent::__construct();
        
    }
}