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

       $this->load->model('Siteparams_model', 'SParams');
   }

   function edit($id=null){
       if(!$this->user)
           return $this->redirect('/admin/me/login?next=' . uri_string());
       if(!$id && !$this->can_i('create-site_param'))
           return $this->show_404();
       if($id && !$this->can_i('update-site_param'))
           return $this->show_404();

       $this->load->library('SiteForm', '', 'form');

       $params = [];

       if($id){
           $object = $this->SParams->get($id);
           if(!$object)
               return $this->show_404();
           $params['title'] = _l('Edit Site Param');
       }else{
           $object = (object)array();
           $params['title'] = _l('Create Site Param');
       }

       $this->form->setObject($object);
       $this->form->setForm('/admin/setting/param');

       $params['param'] = $object;

       if(!($new_object=$this->form->validate($object)))
           return $this->respond('setting/param/edit', $params);

       if($new_object === true)
           return $this->redirect('/admin/setting/param');

       if(!$id){
           $new_object['id'] = $this->SParams->create($new_object);
           $this->event->param->created($new_object);
       }else{
           $this->SParams->set($id, $new_object);
           $this->event->param->updated($object, $new_object);
       }

       $this->cache->file->delete('site_params');
       $this->redirect('/admin/setting/param');
   }

   function index(){
       if(!$this->user)
           return $this->redirect('/admin/me/login?next=' . uri_string());
       if(!$this->can_i('read-site_param'))
           return $this->show_404();

       $params = array(
           'title' => _l('Site Params'),
           'params' => []
       );

       $cond = array();

       $rpp = true;
       $page= false;

       $result = $this->SParams->getByCond($cond, $rpp, $page, ['name'=>'ASC']);
       if($result)
           $params['params'] = $result;

       $this->respond('setting/param/index', $params);
   }

   function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-site_param'))
            return $this->show_404();
            
        $this->event->param->deleted($id);

        $this->cache->file->delete('site_params');
        $this->SParams->remove($id);
        $this->redirect('/admin/setting/param');
   }
}