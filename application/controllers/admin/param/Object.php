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
       if(!$id && !$this->can_i('create_site-param'))
           return $this->show_404();
       if($id && !$this->can_i('update_site-param'))
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
       $this->form->setForm('/admin/param');

       $params['param'] = $object;

       if(!($object=$this->form->validate($object)))
           return $this->respond('param/edit', $params);

       if($object === true)
           return $this->redirect('/admin/param');

       if(!$id){
           $object['id'] = $this->SParams->create($object);
       }else{
           $this->SParams->set($id, $object);
       }

       $this->cache->file->delete('site_params');
       $this->redirect('/admin/param');
   }

   function index(){
       if(!$this->user)
           return $this->redirect('/admin/me/login?next=' . uri_string());
       if(!$this->can_i('read_site-param'))
           return $this->show_404();

       $params = array(
           'title' => _l('Site Params'),
           'params' => []
       );

       $cond = array();

       $rpp = true;
       $page= false;

       $result = $this->SParams->getByCond($cond, $rpp, $page, ['name']);
       if($result)
           $params['params'] = $result;

       $this->respond('param/index', $params);
   }

   function remove($id){
       if(!$this->user)
           return $this->redirect('/admin/me/login?next=' . uri_string());
       if(!$this->can_i('delete_site-param'))
           return $this->show_404();

       $this->cache->file->delete('site_params');
       $this->SParams->remove($id);
       $this->redirect('/admin/param');
   }
}