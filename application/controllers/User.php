<?php

if(!defined('BASEPATH'))
    die;

class User extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function _schemaUser($user){
        $schemas = array();
        
        $data = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Person',
            'email'         => $user->email,
            'jobTitle'      => 'Reporter',
            'description'   => $user->about,
            'image'         => $user->avatar,
            'name'          => $user->fullname,
            'url'           => base_url($user->page)
        );
        $schemas[] = $data;
        
        $breadcs = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => base_url(),
                        'name' => $this->setting->item('site_name')
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => base_url('/#user'),
                        'name' => 'User'
                    )
                )
            )
        );
        
        $schemas[] = $breadcs;
        
        return $schemas;
    }
    
    public function feedPost($name=null){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('User_model', 'User');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $user = $this->User->getBy('name', $name);
        if(!$user)
            return $this->show_404();
        
        $user = $this->formatter->user($user, false, false);
        
        // POSTS
        $cond = array(
            'status'=> 4,
            'user'  => $user->id
        );
        
        $posts = $this->Post->getByCond($cond, 100);
        
        if($posts){
            $posts = $this->formatter->post($posts, false, ['category']);
            foreach($posts as $post){
                $page = (object)array(
                    'page' => base_url($post->page),
                    'description' => $post->seo_description->value ? $post->seo_description : $post->content->chars(160),
                    'title' => $post->title,
                    'categories' => []
                );
                
                if(property_exists($post, 'category')){
                    foreach($post->category as $cat)
                        $page->categories[] = $cat->name;
                }
                
                $pages[] = $page;
                
                if($post->published->time > $last_update)
                    $last_update = $post->published->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url($user->page . '/post/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; User &#187; ' . $user->fullname . ' &#187; Post';
        $params['feed_owner_url'] = base_url($user->page);
        $params['feed_description'] = $user->about->chars(160);
        $params['feed_image_url'] = $user->avatar;
        
        $this->load->view('robot/feed', $params);
    }
    
    public function single($name=null){
        if(!$name)
            return $this->show_404();
        
        $this->load->model('User_model', 'User');
        $user = $this->User->getBy('name', $name);
        if(!$user)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $user = $this->formatter->user($user, false, false);
        $user->schema = $this->_schemaUser($user);
        $params['user'] = $user;
        
        $view = 'user/single';
        if($this->theme->exists('user/single-' . $user->name))
            $view = 'user/single-' . $user->name;
        
        $this->respond($view, $params);
    }
}