<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Category` controller
 */
class Category extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->library('ObjectFormatter', '', 'format');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post_category'))
            return $this->show_404();
        if($id && !$this->can_i('update-post_category'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->PCategory->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Post Category');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Post Category');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/post/category');

        $params['category'] = $object;
        
        // get most possible parents
        $parents = $this->PCategory->getByCond([], true, false, ['name'=>'ASC']);
        if(!$parents)
            $parents = array();
        array_unshift($parents, (object)array('id'=>0,'label'=>_l('None'), 'parent'=>0));
        $params['parents'] = group_by_prop($parents, 'parent');

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/category/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/post/category');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->PCategory->create($new_object);
        }else{
            $this->PCategory->set($id, $new_object);
            
            $object = $this->formatter->post_category($object, false, false);    
            $this->output->delete_cache($object->page);
        }

        $this->redirect('/admin/post/category');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post_category'))
            return $this->show_404();

        $params = array(
            'title' => _l('Post Categories'),
            'categories' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->PCategory->getByCond($cond, $rpp, $page, ['name'=>'ASC']);
        if($result){
            $this->load->library('ObjectFormatter', '', 'format');
            $result = $this->format->post_category($result, false, true);
            $params['categories'] = group_by_prop($result, 'parent');
        }

        $this->respond('post/category/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post_category'))
            return $this->show_404();
        
        $category = $this->PCategory->get($id);
        if(!$category)
            return $this->show_404();
        
        $this->load->model('Postcategorychain_model', 'PCChain');

        $category = $this->formatter->post_category($category, false, false);    
        $this->output->delete_cache($category->page);
        
        $this->PCategory->remove($id);
        $this->PCChain->removeBy('post_category', $id);
        $this->redirect('/admin/post/category');
    }
}