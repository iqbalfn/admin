<?php

if(!defined('BASEPATH'))
    die;

class Setting extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        
        $params = array(
            'title' => _l('My Setting'),
            'success' => false
        );
        
        $this->load->library('SiteForm', '', 'form');
        $this->form->setForm('/admin/me/setting');
        $this->form->setObject($this->user);
        
        if(!($user=$this->form->validate($this->user)))
            return $this->respond('me/setting', $params);
        
        if($user !== true){
            
            // user name
            if(array_key_exists('name', $user)){
                $exists_user = $this->User->getBy('name', $user['name']);
                if($exists_user->id != $this->user->id)
                    $this->form->setError('name', 'The name already exists');
            }
            
            // user email
            if(array_key_exists('email', $user)){
                $exists_user = $this->User->getBy('email', $user['email']);
                if($exists_user && $exists_user->id != $this->user->id)
                    $this->form->setError('email', 'The email already exists');
            }
            
            if(array_key_exists('password', $user)){
                if($user['password'])
                    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
                else{
                    unset($user['password']);
                    if(!count($user))
                        $user = true;
                }
            }
        }
        
        if(!$this->form->errors){
            $params['success'] = true;
            
            if($user !== true){
                $this->User->set($this->user->id, $user);
                $this->event->me->updated($this->user, $user);
            }
        }
        
        $this->respond('me/setting', $params);
    }
}