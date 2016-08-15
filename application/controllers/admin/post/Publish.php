<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Publish` controller
 */
class Publish extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Post_model', 'Post');
        $this->load->model('Postschedule_model', 'PSchedule');
    }
    
    public function index(){
        // get all post that need to be published
        $cond = ['published' => (object)['<',date('Y-m-d H:i:s')]];
        $post_schedules = $this->PSchedule->getByCond($cond, true);
        if(!$post_schedules)
            return;
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $post_schedules = $this->formatter->post_schedule($post_schedules, false, ['post'=>['category','tag']]);
        
        $posts_id = [];
        foreach($post_schedules as $post_schedule){
            $post = $post_schedule->post;
            $posts_id[] = $post->id;
            
            $this->output->delete_cache($post->page);
            $this->output->delete_cache($post->amp);
            
            if(property_exists($post, 'category')){
                $post_categories = $post->category;
                foreach($post_categories as $cat){
                    $this->output->delete_cache($cat->page);
                    $this->output->delete_cache($cat->page . '/feed.xml');
                }
            }
            if(property_exists($post, 'tag')){
                $post_tags = $post->tag;
                foreach($post_tags as $tag){
                    $this->output->delete_cache($tag->page);
                    $this->output->delete_cache($tag->page . '/feed.xml');
                }
            }
        }
        
        $this->output->delete_cache('/');
        $this->output->delete_cache('/post/feed.xml');
        $this->output->delete_cache('/post/instant.xml');
        
        $this->event->post_schedule->published($posts_id);
        
        $this->Post->set($posts_id, ['status'=>4]);
        $this->PSchedule->removeBy('post', $posts_id);
    }
}