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
    
    private function getEditablePermission($user){
        $this->load->model('Userperms_model', 'UPerms');
        $this->load->model('Perms_model', 'Perms');
        
        $user_perms = array();
        if(property_exists($user, 'id')){
            $user_perms = $this->UPerms->getBy('user', $user->id, true);
            if(!$user_perms)
                $user_perms = array();
        }
        
        $user_perms = prop_values($user_perms, 'perms');
        
        $perms = $this->Perms->getByCond([], true);
        $usable_perms = array();
        foreach($perms as $index => $perm){
            $perm->checked = false;
            if(in_array($perm->name, $user_perms))
                $perm->checked = true;
            if($this->can_i($perm->name))
                $usable_perms[] = $perm;
        }
        
        return $usable_perms;
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-user'))
            return $this->show_404();
        if($id && !$this->can_i('update-user'))
            return $this->show_404();
        if($id == 1)
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];
        
        $statuses = $this->enum->item('user.status');
        unset($statuses[0]);
        $params['statuses'] = $statuses;

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
        
        if($this->can_i('update-user_permission')){
            $permissions = $this->getEditablePermission($object);
            $perms = group_by_prop($permissions, 'group');
            ksort($perms);
            
            $params['permissions'] = $perms;
        }
        
        if(!($new_object=$this->form->validate($object)))
            return $this->respond('user/edit', $params);

        // remove user permission and add new one
        $to_insert = array();
        if($this->can_i('update-user_permission')){
            $posted_perms = $this->input->post('perms');
            if(!$posted_perms)
                $posted_perms = array();
            $posted_perms = array_keys($posted_perms);
            
            $changed_permissions = array();
            foreach($permissions as $perms){
                $perm_name = $perms->name;
                $perm_active = $perms->checked;
                
                $posted_active = in_array($perm_name, $posted_perms);
                if($perm_active != $posted_active)
                    $changed_permissions[$perm_name] = $posted_active;
            }
            
            if($changed_permissions){
                $to_remove = array( 'perms' => []);
                
                foreach($changed_permissions as $perm => $value){
                    if(!$value)
                        $to_remove['perms'][] = $perm;
                    else
                        $to_insert[] = array('perms' => $perm);
                }
                
                if($to_remove['perms'] && property_exists($object, 'id')){
                    $to_remove['user'] = $object->id;
                    $this->UPerms->removeByCond($to_remove);
                }
            }
        }
        
        if($new_object === true)
            return $this->redirect('/admin/user');

        if(array_key_exists('password', $new_object)){
            if($new_object['password']){
                if($this->can_i('update-user_password') || !$id)
                    $new_object['password'] = password_hash($new_object['password'], PASSWORD_DEFAULT);
                else
                    unset($new_object['password']);
            }else{
                unset($new_object['password']);
            }
        }
        
        if(!$id){
            $new_object['id'] = $id = $this->User->create($new_object);
            $this->event->user->created($new_object);
        }elseif($new_object){
            $this->User->set($id, $new_object);
            $this->event->user->updated($object, $new_object);
        }

        if($to_insert){
            foreach($to_insert as &$toi)
                $toi['user'] = $id;
            $this->UPerms->create_batch($to_insert);
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
            'users' => [],
            'pagination' => array()
        );

        $cond = array('id' => (object)['!=',1]);

        $args = ['status'];
        foreach($args as $arg){
            $arg_val = $this->input->get($arg);
            if($arg_val)
                $cond[$arg] = $arg_val;
        }
        
        if(!array_key_exists('status', $cond))
            $cond['status'] = (object)['>', 0];
        
        $rpp = 30;
        $page= $this->input->get('page');
        if(!$page)
            $page = 1;
        
        $filter_name = $this->input->get('q');

        $result = $this->User->findByName($cond, $filter_name, $rpp, $page, ['fullname'=>'ASC']);
        unset($cond['id']);
        
        if($result)
            $params['users'] = $result;
        
        $params['statuses'] = $this->enum->item('user.status');
        
        // for pagination
        $total_result = $this->User->findByNameTotal($cond, $filter_name);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            if($filter_name)
                $pagination_cond['q'] = $filter_name;
            
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $this->respond('user/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-user'))
            return $this->show_404();

        $this->event->user->deleted($id);
        $this->User->set($id, ['status'=>0]);
        $this->redirect('/admin/user');
    }
}