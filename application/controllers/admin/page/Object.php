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

        $this->load->model('Page_model', 'Page');
        $this->load->library('ObjectFormatter', '', 'formatter');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-page'))
            return $this->show_404();
        if($id && !$this->can_i('update-page'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Page->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Page');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Page');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/page');

        $params['page'] = $object;
        
        if(!($new_object=$this->form->validate($object)))
            return $this->respond('page/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/page');

        if(!$id){
            $new_object['id'] = $this->Page->create($new_object);
            $this->event->page->created($new_object);
        }else{
            $this->Page->set($id, $new_object);
            
            $this->event->page->updated($object, $new_object);
            
            $object = $this->formatter->page($object, false, false);
            $this->output->delete_cache($object->page);
        }

        $this->redirect('/admin/page');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-page'))
            return $this->show_404();

        $params = array(
            'title' => _l('Pages'),
            'pages' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->Page->getByCond($cond, $rpp, $page, ['title'=>'ASC']);
        if($result)
            $params['pages'] = $this->formatter->page($result);
        
        $this->respond('page/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-page'))
            return $this->show_404();

        $object = $this->Page->get($id);
        if(!$object)
            return $this->show_404();
        
        $this->event->page->deleted($object);
        $object = $this->formatter->page($object, false, false);
        $this->output->delete_cache($object->page);
        
        $this->Page->remove($id);
        $this->redirect('/admin/page');
    }
}