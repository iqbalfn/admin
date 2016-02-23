<?php

if(!defined('BASEPATH'))
    die;

class Auth extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function loginDone(){
        $next = $this->input->get('next');
        
        // only if i can see admin home page
        // or back to index otherwise
        if(!$next){
            $this->load->model('Userperms_model', 'UPerms');
            $cond = array(
                'user' => $this->user->id,
                'perms' => 'read_admin-page'
            );
            $allowed = $this->UPerms->getByCond($cond, 1);
            $next = $allowed ? '/admin' : '/';
        }
        
        if($next)
            return $this->redirect($next);
    }
    
    private function loginSet($user){
        $this->user = $user;
        
        $session = array(
            'user' => $user->id,
            'hash' => password_hash(time().'-'.$user->id, PASSWORD_DEFAULT)
        );
        
        $this->load->model('Usersession_model', 'USession');
        $this->USession->create($session);
        
        $cookie_name = config_item('sess_cookie_name');
        $cookie_expr = config_item('sess_expiration');
        $this->input->set_cookie($cookie_name, $session['hash'], $cookie_expr);
    }
    
    public function login(){
        if($this->user)
            return $this->loginDone();
        
        $this->load->library('SiteForm', '', 'form');
        $this->form->setForm('/admin/me/login');
        
        $params = array(
            'title' => _l('Login')
        );
        
        if(!($login=$this->form->validate()))
            return $this->respond('me/login', $params);
        
        $this->load->model('User_model', 'User');
        
        $name = $login['name'];
        $field = filter_var($name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $user = $this->User->getBy($field, $name, 1);
        
        if(!$user){
            $this->form->setError('name', 'User not found with that identity');
            return $this->respond('me/login', $params);
        }
        
        if(!password_verify($login['password'], $user->password)){
            $this->form->setError('password', 'Invalid password');
            return $this->respond('me/login', $params);
        }
        
        $this->loginSet($user);
        $this->loginDone();
    }
    
    public function logout(){
        if(!$this->user)
            return $this->redirect('/');
        
        $cookie_name = config_item('sess_cookie_name');
        $this->input->set_cookie($cookie_name, '', -15000);
        
        $this->USession->remove($this->session->id);
        
        $this->redirect('/');
    }
}