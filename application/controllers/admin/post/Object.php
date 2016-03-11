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

        $this->load->model('Post_model', 'Post');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post'))
            return $this->show_404();
        if($id && !$this->can_i('update-post'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Post->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Post');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Post');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/post');

        $params['post'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/post');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->Post->create($new_object);
        }else{
            $this->Post->set($id, $new_object);
        }

        $this->redirect('/admin/post');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post'))
            return $this->show_404();

        $params = array(
            'title' => _l('Posts'),
            'posts' => []
        );

        $cond = array();

        $args = ['q','tag','category','status','user'];
        foreach($args as $arg){
            $arg_val = $this->input->get($arg);
            if($arg_val)
                $cond[$arg] = $arg_val;
        }
        
        if(!$this->can_i('read-post_other_user'))
            $cond['user'] = $this->user->id;

        $rpp = 40;
        $page= $this->input->get('page');
        if(!$page)
            $page = 1;

        $result = $this->Post->findByCond($cond, $rpp, $page);
        if($result){
            $this->load->library('ObjectFormatter', '', 'format');
            $params['posts'] = $this->format->post($result, false, true);
        }

        $this->respond('post/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post'))
            return $this->show_404();
        
        $post = $this->Post->get($id);
        if(!$post)
            return $this->show_404();

        if($post->user != $this->user->id && !$this->can_i('delete-post_other_user'))
            return $this->show_404();
        
        $this->load->model('Postcategorychain_model', 'PCChain');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->model('Posttagchain_model', 'PTChain');
        $this->load->model('Posttag_model', 'PTag');
        
        $this->Post->remove($id);
        
        $cats = $this->PCChain->getBy('post', $id);
        if($cats){
            foreach($cats as $cat){
                $this->PCategory->dec($cat->id, 'posts');
                $this->output->delete_cache('/post/category/' . $cat->slug);
            }
            
            $this->PCChain->removeBy('post', $id);
        }
        
        $tags = $this->PTChain->getBy('post', $id);
        if($tags){
            foreach($tags as $tag){
                $this->PTag->dec($tag->id, 'posts');
                $this->output->delete_cache('/post/tag/' . $tag->slug);
            }
            
            $this->PTChain->removeBy('post', $id);
        }
        
        $this->output->delete_cache('/');
        $this->output->delete_cache('/post/read/' . $post->slug);
        $this->cache->file->delete('_recent_posts');
        
        $this->redirect('/admin/post');
    }
}