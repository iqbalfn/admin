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

        $this->load->model('Sitemenu_model', 'SMenu');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-site_menu'))
            return $this->show_404();
        if($id && !$this->can_i('update-site_menu'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $get_field = ['group'];

        $params = [];

        if($id){
            $object = $this->SMenu->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Site Menu');
        }else{
            $object = (object)array();
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if($get_val)
                    $object->$get = $get_val;
            }
            if(!property_exists($object, 'group'))
                return $this->redirect('/admin/setting/menu?e=1');
            $params['title'] = _l('Create Site Menu');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/setting/menu');

        $params['menu'] = $object;
        
        // get most possible parent
        $parents = $this->SMenu->getByCond(['group'=>$object->group], true, false, ['index'=>'ASC']);
        if(!$parents)
            $parents = array();
        array_unshift($parents, (object)array('id'=>0,'label'=>_l('None'), 'parent'=>0));
        $params['parents'] = group_by_prop($parents, 'parent');
        
        if(!($new_object=$this->form->validate($object)))
            return $this->respond('setting/menu/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/setting/menu?group=' . $object->group);

        if(!$id){
            foreach($get_field as $get){
                $get_val = $this->input->get($get);
                if(!array_key_exists($get, $new_object))
                    $new_object[$get] = $get_val;
            }
            
            $new_object['id'] = $this->SMenu->create($new_object);
            
            $this->event->menu->created($new_object);
        }else{
            $this->SMenu->set($id, $new_object);
            
            $this->event->menu->updated($object, $new_object);
        }

        $this->cache->file->delete('site_menu');
        $this->redirect('/admin/setting/menu?group=' . $object->group);
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-site_menu'))
            return $this->show_404();

        $params = array(
            'title' => _l('Site Menus'),
            'menus' => [],
            'current_group' => null,
            'groups' => $this->SMenu->countGrouped('group')
        );
        
        if($this->input->get('group')){
            $params['current_group'] = $this->input->get('group');
            
            $cond = array(
                'group' => $this->input->get('group')
            );
            
            $rpp = true;
            $page= false;

            $result = $this->SMenu->getByCond($cond, $rpp, $page, ['index'=>'ASC']);
            if($result)
                $params['menus'] = $result;
        }
        
        $this->respond('setting/menu/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-site_menu'))
            return $this->show_404();
           
        $next = '/admin/setting/menu';
        if($this->input->get('group'))
            $next.= '?group=' . $this->input->get('group');
        
        $this->event->menu->deleted($id);

        $this->cache->file->delete('site_menu');
        $this->SMenu->remove($id);
        $this->redirect($next);
    }
}