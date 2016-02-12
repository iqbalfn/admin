<?php

if(!defined('BASEPATH'))
    die;

class MY_Controller extends CI_Controller
{
    private $site_params = [];
    private $system_enum = [];
    
    public $user;
    public $session;
    
    function __construct(){
        parent::__construct();
        
        $this->output->set_header('X-Powered-By: ' . config_item('system_vendor'));
        $this->output->set_header('X-Deadpool: ' . config_item('header_message'));
        
        // site_params
        $site_params = $this->cache->file->get('site-params');
        if(!$site_params || is_dev()){
            $this->load->model('Siteparams_model', 'Siteparams');
            $site_params = $this->Siteparams->getByCond([], true);
            if($site_params)
                $site_params = prop_as_key($site_params, 'name', 'value');
            $this->cache->file->save('site-params', $site_params, 604800);
        }
        $this->site_params = $site_params;
        
        // system_enum
        $system_enum = $this->cache->file->get('system-enum');
        if(!$system_enum || is_dev()){
            $this->load->model('Enum_model', 'Enum');
            $system_enum = $this->Enum->getByCond([], true, false, ['id'=>'ASC']);
            if($system_enum){
                $system_enum = group_by_prop($system_enum, 'group');
                foreach($system_enum as $group => $values)
                    $system_enum[$group] = prop_as_key($values, 'value', 'label');
            }
            
            $this->cache->file->save('system-enum', $site_params, 604800);
        }
        $this->system_enum = $system_enum;
        
        // current user
        $cookie_name = config_item('sess_cookie_name');
        $hash = $this->input->cookie($cookie_name);
        if($hash){
            $this->load->model('Usersession_model', 'USession');
            
            $session = $this->USession->getBy('hash', $hash);
            $this->session = $session;
            
            if($session){
                $this->load->model('User_model', 'User');
                
                $user = $this->User->get($session->user);
                $this->user = $user;
                $this->user->perms = array();
                
                if($user){
                    $this->load->model('User_perms', 'UPerms');
                    $user_perms = $this->UPerms->getBy('user', $user->id, true);
                    $this->user->perms = prop_values($user_perms, 'perms');
                }
            }
        }
    }
    
    /**
     * Return to client as ajax respond.
     * @param mixed data The data to return.
     * @param mixed error The error data.
     * @param mixed append Additional data to append to result.
     */
    public function ajax($data, $error=false, $append=null){
        $result = array(
            'data' => $data,
            'error'=> $error
        );
        
        if($append)
            $result = array_merge($result, $append);
        
        $cb = $this->input->get('cb');
        if(!$cb)
            $cb = $this->input->get('callback');
        
        $json = json_encode($result);
        $cset = config_item('charset');
        
        if($cb){
            $json = "$cb($json);";
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/javascript', $cset)
                ->set_output($json)
                ->_display();
            exit;
        }else{
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', $cset)
                ->set_output($json)
                ->_display();
            exit;
        }
    }
    
    /**
     * The system enum setter/getter
     *
     * @param mixed group The enum group name.
     * @param mixed value The option value, for setter label, or label getter.
     * @param mixed label The option label, for setter label only
     */
    public function enum($group, $value=null, $label=null){
        if($label){
            if(!array_key_exists($group, $this->system_enum))
                $this->system_enum[$group] = array();
            $this->system_enum[$group][$value] = $label;
        }
        
        if(is_null($value)){
            if(array_key_exists($group, $this->system_enum))
                return $this->system_enum[$group];
            return false;
        }
        
        if(is_null($label)){
            if(!array_key_exists($group, $this->system_enum))
                return false;
            if(array_key_exists($value, $this->system_enum[$group]))
                return $this->system_enum[$group][$value];
            return false;
        }
        
        return $label;
    }
    
    /**
     * Redirect to some URL.
     * @param string next Target URL.
     * @param integer status Redirect status.
     */
    public function redirect($next='/', $status=NULL){
        if(substr($next, 0, 4) != 'http')
            $next = base_url($next);
        
        redirect($next, 'auto', $status);
    }
    
    /**
     * Print page.
     * @param string view The view to load.
     * @param array params The parameters to send to view.
     */
    public function respond($view, $params=array()){
        $page_title = '';
        if(array_key_exists('title', $params))
            $page_title = $params['title'] . ' - ';
        $page_title.= $this->setting('site_name');
        
        $params['page_title'] = $page_title;
        
        // template
        if($this->uri->segment(1) == 'admin')
            $this->setting('site_theme', 'admin');
        
        $view = $this->setting('site_theme') . '/' . $view;
        
        $this->load->view($view, $params);
    }
    
    /**
     * Set or get setting
     * @param string name The setting name
     * @param mixed value The setting value, only for setter.
     * @return setting value.
     */
    public function setting($name, $value=null){
        if($value)
            $this->site_params[$name] = $value;
        if(array_key_exists($name, $this->site_params))
            return $this->site_params[$name];
        return false;
    }
    
    /**
     * Print 404 page
     */
    public function show_404(){
        $this->output->set_status_header('404');
        
        $params = array(
            'title' => _l('Page not found')
        );
        
        $this->respond('404', $params);
    }
}