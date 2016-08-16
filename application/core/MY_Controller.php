<?php

if(!defined('BASEPATH'))
    die;

class MY_Controller extends CI_Controller
{
    public $session;
    public $user;
    
    function __construct(){
        parent::__construct();
        
        $this->output->set_header('X-Powered-By: ' . config_item('system_vendor'));
        $this->output->set_header('X-Deadpool: ' . config_item('header_message'));
        
        $this->load->library('SiteEnum', '', 'enum');
        $this->load->library('SiteParams', '', 'setting');
        $this->load->library('SiteTheme', '', 'theme');
        $this->load->library('SiteMenu', '', 'menu');
        $this->load->library('SiteForm', '', 'form');
        $this->load->library('SiteMeta', '', 'meta');
        $this->load->library('ObjectMeta', '', 'ometa');
        $this->load->library('ActionEvent', '', 'event');

        $cookie_name = config_item('sess_cookie_name');
        $hash = $this->input->cookie($cookie_name);
        
        if($hash){
            $this->load->model('Usersession_model', 'USession');
            $session = $this->USession->getBy('hash', $hash);
            $this->session = $session;
            
            if($session){
                $this->load->model('User_model', 'User');
                $user = $this->User->get($session->user);
                
                // TODO
                // Increase session expiration if it's almost expired
                
                if($user && $user->status > 1){
                    $this->user = $user;
                    $this->user->perms = [];
                    
                    if($user){
                        if($user->id == 1){
                            $this->load->model('Perms_model', 'Perms');
                            $user_perms = $this->Perms->getByCond([], true, false);
                            $this->user->perms = prop_values($user_perms, 'name');
                        }else{
                            $this->load->model('Userperms_model', 'UPerms');
                            $user_perms = $this->UPerms->getBy('user', $user->id, true);
                            if($user_perms)
                                $this->user->perms = prop_values($user_perms, 'perms');
                        }
                        
                        $this->user->perms[] = 'logged_in';
                    }
                }
            }
        }
        
        if($this->theme->current() == 'admin/')
            $this->lang->load('admin', config_item('language'));
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
     * Check if current admin user can do something
     * @param string perms The perms to check.
     * @return boolean true on allowed, false otherwise.
     */
    public function can_i($perms){
        if(!$this->user)
            return false;
        return in_array($perms, $this->user->perms);
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
        $page_title.= $this->setting->item('site_name');
        
        $params['page_title'] = $page_title;
        
        if(!$this->theme->exists($view) && !is_dev())
            return $this->show_404();
        
        $this->theme->load($view, $params);
    }
    
    /**
     * Print 404 page
     */
    public function show_404(){
        $this->load->model('Urlredirection_model', 'Redirection');
        
        $next = $this->Redirection->getBy('source', uri_string());
        if($next)
            return $this->redirect($next->target, 301);
    
        $this->output->set_status_header('404');

        $params = array(
            'title' => _l('Page not found')
        );
        
        $this->respond('404', $params);
    }
}