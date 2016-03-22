<?php

if(!defined('BASEPATH'))
    die;

class User extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function single($name=null){
        if(!$name)
            return $this->show_404();
        
        $this->load->model('User_model', 'User');
        $user = $this->User->getBy('name', $name);
        if(!$user)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $params['user'] = $this->formatter->user($user, false, false);
        
        $view = 'user/single';
        if($this->theme->exists('user/single-' . $user->name))
            $view = 'user/single-' . $user->name;
        
        $this->respond($view, $params);
    }
}