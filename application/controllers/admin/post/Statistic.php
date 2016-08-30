<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Statistic` controller
 */
class Statistic extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Post_model', 'Post');
        $this->load->model('Poststatistic_model', 'PStatistic');
        $this->load->library('Google');
    }
    
    public function index(){
        if(!$this->setting->item('google_analytics_statistic'))
            deb('GA Statistic file not set');
            
        ignore_user_abort(true);
        set_time_limit(0);
        
        $last_one_hours = strtotime('-1 hours', time());
        
        $date_start = date('Y-m-d', $last_one_hours);
        $date_end = date('Y-m-d', $last_one_hours);
        $hour_start = date('H', $last_one_hours);
        
        // make sure we're not re run on the some hour
        $last_hour = $this->cache->file->get('post_statistic_last_crawler');
        if($last_hour && $last_hour == $hour_start)
            deb('We already run this time');
        $this->cache->file->save('post_statistic_last_crawler', $hour_start, 604800);
        
        // we're implementing google API v4
        $access_token = $this->google->get_analytics_token();
        $ga_client = $this->google->getClient();
        
        $ga_analytics = new Google_Service_Analytics($ga_client);
        
        $view_id = $this->setting->item('code_google_analytics_view');
        
        $opts = array(
            'filters' => 'ga:pagePath=@/post/read;ga:hour==' . $hour_start,
            'dimensions' => 'ga:pagePath',
            'sort' => '-ga:pageviews',
            'max-results' => 1000
        );
        $result = $ga_analytics->data_ga->get("ga:$view_id", $date_start, $date_end, 'ga:pageviews,ga:users,ga:sessions', $opts);
        
        if($result->error)
            deb($result->error);
        $rows = $result->rows;
        if(!count($rows))
            deb('No page view found for yesterday');
        
        $results = array();
        $slugs   = array();
        foreach($rows as $row){
            if(!preg_match('!^\/post\/read\/([a-z0-9-]+)!', $row[0], $match))
                continue;
            
            $slug = $match[1];
            $slugs[] = $slug;
            $results[$slug] = array(
                'pageviews' => $row[1],
                'sessions' => $row[3],
                'users' => $row[2]
            );
        }
        
        $posts_id = $this->Post->getBy('slug', $slugs, true);
        if(!$posts_id)
            deb('No post to update');
        
        $post_slug_to_id = prop_as_key($posts_id, 'slug', 'id');
        
        $to_update = array();
        foreach($results as $slug => $result){
            if(!array_key_exists($slug, $post_slug_to_id))
                continue;
            $result['post'] = $post_slug_to_id[$slug];
            $to_update[] = $result;
        }
        
        // this is the long road to the DB
        foreach($to_update as $stat){
            $exists_stats = $this->PStatistic->getBy('post', $stat['post'], false, false, ['post']);
            if($exists_stats)
                $this->PStatistic->incStat($stat);
            else
                $this->PStatistic->create($stat);
        }
        
        deb('Inserted ' . count($to_update) . ' statistic');
    }
}