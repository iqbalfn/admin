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
        $this->load->library('ObjectFormatter', '', 'formatter');
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
            
            $this->event->post_category->created($new_object);
        }else{
            $this->PCategory->set($id, $new_object);
            
            $this->event->post_category->updated($object, $new_object);
            
            $object = $this->formatter->post_category($object, false, false);    
            $this->output->delete_cache($object->page);
            $this->output->delete_cache($object->page . '/feed.xml');
            
            // Delete all post cache that use me
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
            $result = $this->formatter->post_category($result, false, true);
            $groupped_result = [];
            foreach($result as $row){
                $parent = 0;
                if($row->parent && is_object($row->parent))
                    $parent = $row->parent->id;
                if(!array_key_exists($parent, $groupped_result))
                    $groupped_result[$parent] = array();
                $groupped_result[$parent][] = $row;
            }
            $params['categories'] = $groupped_result;
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

        $this->event->post_category->deleted($category);
        
        $category = $this->formatter->post_category($category, false, false);
        $this->output->delete_cache($category->page);
        $this->output->delete_cache($category->page . '/feed.xml');
        
        $this->PCategory->remove($id);
        $this->PCChain->removeBy('post_category', $id);
        
        $this->redirect('/admin/post/category');
    }
}