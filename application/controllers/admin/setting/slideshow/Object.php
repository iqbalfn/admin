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

        $this->load->model('Slideshow_model', 'Slideshow');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-slide_show'))
            return $this->show_404();
        if($id && !$this->can_i('update-slide_show'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $get_field = ['group'];

        $params = [];

        if($id){
            $object = $this->Slideshow->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit SlideShow');
        }else{
            $object = (object)array();
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if($get_val)
                    $object->$get = $get_val;
            }
            $params['title'] = _l('Create SlideShow');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/setting/slideshow');

        $params['slide'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('setting/slideshow/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/setting/slideshow?group=' . $object->group);

        if(!$id){
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if(!array_key_exists($get, $new_object))
                    $new_object[$get] = $get_val;
            }
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->Slideshow->create($new_object);
            
            $this->event->slideshow->created($new_object);
        }else{
            $this->Slideshow->set($id, $new_object);
            
            $this->event->slideshow->updated($object, $new_object);
        }

        $this->redirect('/admin/setting/slideshow?group=' . $object->group);
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-slide_show'))
            return $this->show_404();

        $params = array(
            'title' => _l('SlideShow'),
            'slides' => [],
            'current_group' => null,
            'groups' => $this->Slideshow->countGrouped('group')
        );
        
        if($this->input->get('group')){
            $params['current_group'] = $this->input->get('group');
            
            $cond = array(
                'group' => $this->input->get('group')
            );
            
            $rpp = true;
            $page= false;

            $result = $this->Slideshow->getByCond($cond, $rpp, $page, ['index'=>'ASC']);
            if($result){
                $this->load->library('ObjectFormatter', '', 'formatter');
                $params['slides'] = $this->formatter->slideshow($result);
            }
        }
        
        $this->respond('setting/slideshow/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-slide_show'))
            return $this->show_404();
        
        $next = '/admin/setting/slideshow';
        if($this->input->get('group'))
            $next.= '?group=' . $this->input->get('group');
        
        $this->event->slideshow->deleted($id);

        $this->Slideshow->remove($id);
        $this->redirect($next);
    }
}