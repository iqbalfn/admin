<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->model('Enum_model', 'Enum');
    }
    
    public function edit($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create_system-enum'))
            return $this->show_404();
        if($id && !$this->can_i('update_system-enum'))
            return $this->show_404();
        
        $this->load->library('SiteForm', '', 'form');
        
        $params = [];
        
        if($id){
            $enum = $this->Enum->get($id);
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
        $this->form->setForm('/admin/enum');
        
        $params['enum'] = $enum;
        
        if(!($enum=$this->form->validate($enum)))
            return $this->respond('enum/edit', $params);
        
        if($enum === true)
            return $this->redirect('/admin/enum');
        
        if(!$id){
            if(!array_key_exists('group', $enum))
                $enum['group'] = $this->input->get('group');
            
            $enum['id'] = $this->Enum->create($enum);
        }else{
            $this->Enum->set($id, $enum);
            
        }
        
        $this->cache->file->delete('system-enum');
        
        $this->redirect('/admin/enum');
    }
    
    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read_system-enum'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Site Enums'),
            'enums' => []
        );
        
        $enums = $this->Enum->getByCond([], true);
        if($enums)
            $params['enums'] = group_by_prop($enums, 'group');
        
        $this->respond('enum/index', $params);
    }
    
    public function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete_system-enum'))
            return $this->show_404();
        
        $this->Enum->remove($id);
        $this->cache->file->delete('system-enum');
        $this->redirect('/admin/enum');
    }
}