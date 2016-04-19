<?php

if(!defined('BASEPATH'))
    die;

class Post extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function amp($slug=null){
        if(!$slug || !$this->setting->item('amphtml_support_for_post'))
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        $this->load->library('Camp/Camp', '', 'camp');
        
        $params = [];
        
        $post = $this->Post->getBy('slug', $slug);
        if(!$post || $post->status != 4)
            return $this->show_404();
        
        $post = $this->formatter->post($post, false, true);
        
        $amp_options = [];
        $amp_text = $post->content . '<p>' . $post->embed . '</p>';
        $amp = $this->camp->convert($amp_text, $amp_options);
        
        $post->components  = $amp->components;
        $post->amp_content = $amp->amp;
        
        $params['post'] = $post;
        
        $view = 'post/amp';
        $this->respond($view, $params);
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
            
            unset($pagination_cond['category']);
            unset($pagination_cond['status']);
            
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/category/single';
        if($this->theme->exists('post/category/single-' . $category->slug))
            $view = 'post/category/single-' . $category->slug;
        
        $this->respond($view, $params);
    }
    
    public function categoryFeed($slug=null){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $category = $this->PCategory->getBy('slug', $slug);
        if(!$category)
            return $this->show_404();
        
        $category = $this->formatter->post_category($category, false, false);
        
        // POSTS
        $cond = array(
            'status'    => 4,
            'category'  => $category->id
        );
        
        $posts = $this->Post->findByCond($cond, 100);
        
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
        
        $params['feed_url'] = base_url($category->page . '/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; Post &#187; Category &#187; ' . $category->name;
        $params['feed_owner_url'] = base_url($category->page);
        $params['feed_description'] = $category->seo_description->value ? $category->seo_description : $category->description;
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
    }
    
    public function feed(){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        // POSTS
        $cond = array(
            'status'    => 4
        );
        $posts = $this->Post->getByCond($cond, true);
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
        
        $params['feed_url'] = base_url('/post/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; Post';
        $params['feed_owner_url'] = base_url();
        $params['feed_description'] = $this->setting->item('site_frontpage_description');
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
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
            unset($pagination_cond['tag']);
            unset($pagination_cond['status']);
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/tag/single';
        if($this->theme->exists('post/tag/single-' . $tag->slug))
            $view = 'post/tag/single-' . $tag->slug;
        
        $this->respond($view, $params);
    }
    
    public function tagFeed($slug=null){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $tag = $this->PTag->getBy('slug', $slug);
        if(!$tag)
            return $this->show_404();
        
        $tag = $this->formatter->post_tag($tag, false, false);
        
        // POSTS
        $cond = array(
            'status'    => 4,
            'tag'  => $tag->id
        );
        
        $posts = $this->Post->findByCond($cond, 100);
        
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
        
        $params['feed_url'] = base_url($tag->page . '/feed.xml');
        $params['feed_title'] = $this->setting->item('site_name') . ' &#187; Post &#187; Tag &#187; ' . $tag->name;
        $params['feed_owner_url'] = base_url($tag->page);
        $params['feed_description'] = $tag->seo_description->value ? $tag->seo_description : $tag->description;
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
    }
}