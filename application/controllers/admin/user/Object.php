<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Object` controller
 */
class Object extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('User_model', 'User');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-user'))
            return $this->show_404();
        if($id && !$this->can_i('update-user'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->User->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit User');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New User');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/user');

        $params['user'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('user/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/user');

        if(!$id){
            $new_object['id'] = $this->User->create($new_object);
        }else{
            $this->User->set($id, $new_object);
        }

        $this->redirect('/admin/user');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-user'))
            return $this->show_404();

        $params = array(
            'title' => _l('Users'),
            'users' => []
        );

        $cond = array();

        $args = ['status'];
        foreach($args as $arg){
            $arg_val = $this->input->get($arg);
            if($arg_val)
                $cond[$arg] = $arg_val;
        }
        
        $rpp = 40;
        $page= $this->input->get('page');
        if(!$page)
            $page = 1;

        $result = $this->User->findByName($cond, $this->input->get('q'), $rpp, $page, ['fullname'=>'ASC']);
        
        if($result)
            $params['users'] = $result;
        
        $params['statuses'] = $this->enum->item('user.status');

        $this->respond('user/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-user'))
            return $this->show_404();

        $this->user->set($id, ['status'=>0]);
        $this->redirect('/admin/user');
    }
}