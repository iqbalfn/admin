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

        $this->load->model('Event_model', 'Event');
        $this->load->library('ObjectFormatter', '', 'formatter');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-event'))
            return $this->show_404();
        if($id && !$this->can_i('update-event'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Event->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Event');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Event');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/event');

        $params['event'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('event/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/event');

        if(!$id){
            $new_object['id'] = $this->Event->create($new_object);
            $this->event->event->created($new_object);
            
        }else{
            $this->Event->set($id, $new_object);
            
            $this->event->event->updated($object, $new_object);
            $object = $this->formatter->event($object, false, false);
            $this->output->delete_cache($object->page);
        }

        $this->redirect('/admin/event');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-event'))
            return $this->show_404();

        $params = array(
            'title' => _l('Events'),
            'events' => []
        );

        $cond = array();

        $rpp = 50;
        $page= $this->input->get('page');
        if(!$page)
            $page = 1;

        $result = $this->Event->getByCond($cond, $rpp, $page);
        if($result)
            $params['events'] = $this->formatter->event($result, false, true);

        $this->respond('event/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-event'))
            return $this->show_404();

        $event = $this->Event->get($id);
        if(!$event)
            return $this->show_404();
        
        $this->event->event->deleted($event);
        
        $event = $this->formatter->event($event, false, false);
        
        $this->output->delete_cache($event->page);
        $this->Event->remove($id);
        $this->redirect('/admin/event');
    }
}