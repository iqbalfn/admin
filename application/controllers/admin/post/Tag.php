<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Tag` controller
 */
class Tag extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Posttag_model', 'PTag');
        $this->load->library('ObjectFormatter', '', 'format');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post_tag'))
            return $this->show_404();
        if($id && !$this->can_i('update-post_tag'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->PTag->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Post Tag');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Post Tag');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/post/tag');

        $params['tag'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/tag/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/post/tag');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->PTag->create($new_object);
        }else{
            $this->PTag->set($id, $new_object);
            
            $object = $this->formatter->post_tag($object, false, false);    
            $this->output->delete_cache($object->page);
            $this->output->delete_cache($object->page . '/feed.xml');
        }

        $this->redirect('/admin/post/tag');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post_tag'))
            return $this->show_404();

        $params = array(
            'title' => _l('Post Tags'),
            'tags' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->PTag->getByCond($cond, $rpp, $page);
        if($result){
            $this->load->library('ObjectFormatter', '', 'format');
            $params['tags'] = $this->format->post_tag($result, false, true);
        }

        $this->respond('post/tag/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post_tag'))
            return $this->show_404();
        
        $tag = $this->PTag->get($id);
        if(!$tag)
            return $this->show_404();

        $this->load->model('Posttagchain_model', 'PTChain');
        $tag = $this->formatter->post_tag($tag, false, false);    
        $this->output->delete_cache($tag->page);
        $this->output->delete_cache($tag->page . '/feed.xml');
        
        $this->PTag->remove($id);
        $this->PTChain->removeBy('post_tag', $id);
        $this->redirect('/admin/post/tag');
    }
}