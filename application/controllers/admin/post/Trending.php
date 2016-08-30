<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Trending` controller
 */
class Trending extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Post_model', 'Post');
        $this->load->model('Posttagchain_model', 'PTChain');
        $this->load->model('Posttrending_model', 'PTrending');
        $this->load->model('Postcategorychain_model', 'PCChain');
        $this->load->library('Google');
    }
    
    public function index(){
        if(!$this->setting->item('google_analytics_statistic'))
            deb('GA Statistic file not set');
        
        // we're implementing google API v4
        $access_token = $this->google->get_analytics_token();
        $ga_client = $this->google->getClient();
        
        $ga_analytics = new Google_Service_Analytics($ga_client);
        
        $view_id = $this->setting->item('code_google_analytics_view');
        $date_start = date('Y-m-d', strtotime('-3 days', time()));
        $date_end = date('Y-m-d');
        $opts = array(
            'filters' => 'ga:pagePath=@/post/read',
            'dimensions' => 'ga:pagePath',
            'sort' => '-ga:pageviews',
            'max-results' => 500
        );
        $result = $ga_analytics->data_ga->get("ga:$view_id", $date_start, $date_end, 'ga:pageviews,ga:users,ga:sessions', $opts);
        
        if($result->error)
            deb($result->error);
            
        $rows = $result->rows;
        $post_views = array();
        
        foreach($rows as $row){
            $slug = str_replace('/post/read/', '', $row[0]);
            $pageviews = $row[1];
            $users = $row[2];
            $sessions = $row[3];
            $post_views[$slug] = array( 
                'pageviews' => $pageviews,
                'sessions'  => $sessions,
                'users'     => $users
            );
        }
        
        // we need to process them separatly to reduce server usage
        $post_views = group_per_column($post_views, 20);
        
        $insertion = array();
        foreach($post_views as $group){
            $posts_slug = array_keys($group);
            $posts = $this->Post->getBy('slug', $posts_slug, true);
            if(!$posts)
                continue;
            
            $posts = prop_as_key($posts, 'slug');
            foreach($group as $slug => $stat){
                if(!array_key_exists($slug, $posts))
                    continue;
                $posts[$slug]->view = $stat['pageviews'];
                $insertion[] = array(
                    'post' => $posts[$slug]->id,
                    'tag'  => null,
                    'category' => null,
                    'view' => $stat['pageviews']
                );
                
                $group[$slug]['post'] = $posts[$slug]->id;
            }
            
            $posts_by_id = prop_as_key($posts, 'id');
            
            $posts_id = array_keys($posts_by_id);
            
            $post_tags = $this->PTChain->getBy('post', $posts_id, true);
            if($post_tags){
                foreach($post_tags as $tag){
                    $insertion[] = array(
                        'post' => $tag->post,
                        'tag'  => $tag->post_tag,
                        'category' => null,
                        'view' => $posts_by_id[$tag->post]->view
                    );
                }
            }
            
            $post_categories = $this->PCChain->getBy('post', $posts_id, true);
            if($post_categories){
                foreach($post_categories as $cat){
                    $insertion[] = array(
                        'post' => $cat->post,
                        'tag'  => null,
                        'category' => $cat->post_category,
                        'view' => $posts_by_id[$cat->post]->view
                    );
                }
            }
        }
        
        if($insertion){
            $this->PTrending->truncate();
            $this->PTrending->create_batch($insertion);
            
            $this->event->post_trending->calculated($insertion);
        }
        
        deb('Inserted ' . count($insertion) . ' trending');
        file_put_contents(dirname(BASEPATH) . '/last-update.txt', time());
    }
}