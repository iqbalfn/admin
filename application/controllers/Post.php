<?php

if(!defined('BASEPATH'))
    die;

class Post extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function category($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array(
            'posts' => array(),
            'pagination' => array()
        );
        
        $category = $this->PCategory->getBy('slug', $slug);
        if(!$category)
            return $this->show_404();
        
        $params['category'] = $this->formatter->post_category($category, false, false);
        
        // posts
        $cond = array(
            'status' => 4,
            'category' => $category->id
        );
        
        $rpp = 12;
        $page = $this->input->get('page');
        if(!$page)
            $page = 1;
        
        $posts = $this->Post->findByCond($cond, $rpp, $page);
        if($posts)
            $params['posts'] = $this->formatter->post($posts);
        
        $total_result = $this->Post->findByCondTotal($cond);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/category/single';
        if($this->theme->exists('post/category/single-' . $category->slug))
            $view = 'post/category/single-' . $category->slug;
        
        $this->respond($view, $params);
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array();
        
        $post = $this->Post->getBy('slug', $slug);
        if(!$post || $post->status != 4)
            return $this->show_404();
        
        $params['post'] = $this->formatter->post($post, false, true);
        
        $view = 'post/single';
        if($this->theme->exists('post/single-' . $post->slug))
            $view = 'post/single-' . $post->slug;
        
        $this->respond($view, $params);
    }
    
    public function tag($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array(
            'posts' => array(),
            'pagination' => array()
        );
        
        $tag = $this->PTag->getBy('slug', $slug);
        if(!$tag)
            return $this->show_404();
        
        $params['tag'] = $this->formatter->post_tag($tag, false, false);
        
        // posts
        $cond = array(
            'status' => 4,
            'tag' => $tag->id
        );
        
        $rpp = 12;
        $page = $this->input->get('page');
        if(!$page)
            $page = 1;
        
        $posts = $this->Post->findByCond($cond, $rpp, $page);
        if($posts)
            $params['posts'] = $this->formatter->post($posts);
        
        $total_result = $this->Post->findByCondTotal($cond);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/tag/single';
        if($this->theme->exists('post/tag/single-' . $tag->slug))
            $view = 'post/tag/single-' . $tag->slug;
        
        $this->respond($view, $params);
    }
}