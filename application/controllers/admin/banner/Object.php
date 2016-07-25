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

        $this->load->model('Banner_model', 'Banner');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-banner'))
            return $this->show_404();
        if($id && !$this->can_i('update-banner'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Banner->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Banner');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Banner');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/banner');

        $params['banner'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('banner/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/banner');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->Banner->create($new_object);
            $this->event->banner->created($new_object);
        }else{
            $this->Banner->set($id, $new_object);
            $this->event->banner->updated($object, $new_object);
        }

        $this->cache->file->delete('banner');
        $this->redirect('/admin/banner');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-banner'))
            return $this->show_404();

        $params = array(
            'title' => _l('Banners'),
            'banners' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->Banner->getByCond($cond, $rpp, $page, ['name'=>'ASC']);
        if($result){
            $this->load->library('ObjectFormatter', '', 'format');
            $params['banners'] = $this->format->banner($result, false, true);
        }

        $this->respond('banner/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-banner'))
            return $this->show_404();

        $this->cache->file->delete('banner');
        $this->event->banner->deleted($id);
        
        $this->Banner->remove($id);
        $this->redirect('/admin/banner');
    }
}