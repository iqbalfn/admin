<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->model('Siteenum_model', 'SEnum');
    }
    
    public function edit($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-site_enum'))
            return $this->show_404();
        if($id && !$this->can_i('update-site_enum'))
            return $this->show_404();
        
        $this->load->library('SiteForm', '', 'form');
        
        $params = [];
        
        if($id){
            $enum = $this->SEnum->get($id);
            if(!$enum)
                return $this->show_404();
            $params['title'] = _l('Edit Site Enum');
        }else{
            $enum = (object)array(
                'group' => $this->input->get('group')
            );
            $params['title'] = _l('Create Site Enum');
        }
        
        $this->form->setObject($enum);
        $this->form->setForm('/admin/setting/enum');
        
        $params['enum'] = $enum;
        
        if(!($new_enum=$this->form->validate($enum)))
            return $this->respond('setting/enum/edit', $params);
        
        if($new_enum === true)
            return $this->redirect('/admin/setting/enum');
        
        if(!$id){
            if(!array_key_exists('group', $new_enum))
                $new_enum['group'] = $this->input->get('group');
            
            $new_enum['id'] = $this->SEnum->create($new_enum);
            
            $this->event->enum->created($new_enum);
        }else{
            $this->SEnum->set($id, $new_enum);
            
            $this->event->enum->updated($enum, $new_enum);
        }
        
        $this->cache->file->delete('site_enum');
        
        $this->redirect('/admin/setting/enum');
    }
    
    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-site_enum'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Site Enums'),
            'enums' => []
        );
        
        $enums = $this->SEnum->getByCond([], true);
        if($enums)
            $params['enums'] = group_by_prop($enums, 'group');
        
        $this->respond('setting/enum/index', $params);
    }
    
    public function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-site_enum'))
            return $this->show_404();
        
        $this->event->enum->deleted($id);
        
        $this->SEnum->remove($id);
        $this->cache->file->delete('site_enum');
        $this->redirect('/admin/setting/enum');
    }
}