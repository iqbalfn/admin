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

        $this->load->model('Urlredirection_model', 'URedirection');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-url_redirection'))
            return $this->show_404();
        if($id && !$this->can_i('update-url_redirection'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->URedirection->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit URL Redirection');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New URL Redirection');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/setting/redirection');

        $params['url'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('setting/redirection/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/setting/redirection');

        if(array_key_exists('source', $new_object))
            $new_object['source'] = trim($new_object['source'], '/');
        
        if(!$id){
            $new_object['id'] = $this->URedirection->create($new_object);
            $this->event->redirection->created($object, $new_object);
        }else{
            $this->URedirection->set($id, $new_object);
            $this->event->redirection->updated($object, $new_object);
        }

        $this->redirect('/admin/setting/redirection');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-url_redirection'))
            return $this->show_404();

        $params = array(
            'title' => _l('URL Redirection'),
            'urls' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->URedirection->getByCond($cond, $rpp, $page, ['source'=>'ASC']);
        if($result)
            $params['urls'] = $result;

        $this->respond('setting/redirection/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-url_redirection'))
            return $this->show_404();
        
        $this->event->redirection->deleted($id);

        $this->URedirection->remove($id);
        $this->redirect('/admin/setting/redirection');
    }
}