<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Selection` controller
 */
class Selector extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Postselection_model', 'PSelection');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post_selector'))
            return $this->show_404();
        if($id && !$this->can_i('update-post_selector'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $get_field = ['group'];

        $params = [
            'posts' => []
        ];

        if($id){
            $object = $this->PSelection->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Post Selection');
            $this->load->model('Post_model', 'Post');
            $post = $this->Post->get($object->post);
            if($post)
                $params['posts'] = [$post->id => $post->title];
        }else{
            $object = (object)array();
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if($get_val)
                    $object->$get = $get_val;
            }
            $params['title'] = _l('Create New Post Selection');
        }
        
        if(!property_exists($object, 'group'))
            return $this->redirect('/admin/post/selector');

        $this->form->setObject($object);
        $this->form->setForm('/admin/post/selector');

        $params['selection'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/selector/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/post/selector?group=' . $object->group);

        if(!$id){
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if(!array_key_exists($get, $new_object))
                    $new_object[$get] = $get_val;
            }
            $new_object['id'] = $this->PSelection->create($new_object);
            $this->event->post_selection->created($new_object);
        }else{
            $this->PSelection->set($id, $new_object);
            $this->event->post_selection->updated($object, $new_object);
        }

        $this->redirect('/admin/post/selector?group=' . $object->group);
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post_selector'))
            return $this->show_404();

        $params = array(
            'title' => _l('Post Selection'),
            'selections' => [],
            'current_group' => null,
            'groups' => $this->PSelection->countGrouped('group')
        );
        
        if($this->input->get('group')){
            $params['current_group'] = $this->input->get('group');
            
            $cond = array(
                'group' => $this->input->get('group')
            );
            
            $rpp = true;
            $page= false;

            $result = $this->PSelection->getByCond($cond, $rpp, $page, ['index'=>'ASC']);
            
            if($result){
                $this->load->library('ObjectFormatter', '', 'formatter');
                $params['selections'] = $this->formatter->post_selection($result, false, ['post']);
            }
        }
        
        $this->respond('post/selector/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post_selector'))
            return $this->show_404();
        
        $next = '/admin/post/selector';
        if($this->input->get('group'))
            $next.= '?group=' . $this->input->get('group');

        $this->event->post_selection->deleted($id);
        
        $this->PSelection->remove($id);
        $this->redirect($next);
    }
}