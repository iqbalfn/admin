<?php

if(!defined('BASEPATH'))
    die;

/**
 * The 'Suggestion' controller
 */
class Suggestion extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Postsuggestion_model', 'Postsuggestion');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post_suggestion'))
            return $this->show_404();
        if($id && !$this->can_i('update-post_suggestion'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Postsuggestion->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Post Suggestion');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Post Suggestion');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/post/suggestion');

        $params['post'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/suggestion/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/post/suggestion');

        if(!$id){
            $new_object['id'] = $this->Postsuggestion->create($new_object);
            $this->event->post_suggestion->created($new_object);
        }else{
            $this->Postsuggestion->set($id, $new_object);
            $this->event->post_suggestion->updated($object, $new_object);
        }

        $this->redirect('/admin/post/suggestion');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post_suggestion'))
            return $this->show_404();

        $params = array(
            'title' => _l('Post Suggestion'),
            'posts' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->Postsuggestion->getByCond($cond, $rpp, $page, ['local'=>'ASC']);
        if($result){
            $this->load->library('ObjectFormatter', '', 'format');
            $params['posts'] = $this->format->post_suggestion($result, false, true);
        }

        $this->respond('post/suggestion/index', $params);
    }

    public function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post_suggestion'))
            return $this->show_404();
        
        $this->event->post_suggestion->deleted($id);

        $this->Postsuggestion->remove($id);
        $this->redirect('/admin/post/suggestion');
    }
}