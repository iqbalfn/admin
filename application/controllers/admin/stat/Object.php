<?php

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
        $this->load->model('Siteranks_model', 'Rank');
    }
    
    private function _calculate_alexa(){
        $uri = 'http://data.alexa.com/data?cli=10&url=' . base_url();
        
        $cu = curl_init($uri);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($cu);
        if(!$result)
            return false;
        
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        if(!array_key_exists('SD', $array))
            return false;
        
        $array = $array['SD'];
        
        $data = array(
            'rank_international' => ['POPULARITY', '@attributes', 'TEXT'],
            'rank_local' => ['COUNTRY', '@attributes', 'RANK']
        );
        
        $ranks = array();
        foreach($data as $prop => $dat){
            $value = $array;
            foreach($dat as $pro){
                if(!array_key_exists($pro, $value))
                    break;
                $value = $value[$pro];
            }
            
            $ranks[$prop] = (int)$value;
        }
        
        $this->event->stat->alexa_calculated($ranks);
        return $ranks;
    }
    
    public function _calculate_similarweb(){
        $urls = parse_url(base_url());
        $uri = 'https://www.similarweb.com/website/' . $urls['host'];
        
        $cu = curl_init($uri);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cu, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0');
        $result = curl_exec($cu);
        if(!$result)
            return false;
        
        preg_match_all('!<span class="rankingItem-value js-countable" data-value="([0-9,]+)">([0-9,]+)</span>!', $result, $match);
        if(!array_key_exists(1, $match) || !$match[1])
            return false;

        $match = $match[1];
        $ranks = array(
            'rank_international' => array_key_exists(0, $match) ? str_replace(',', '', $match[0]) : 0,
            'rank_local' => array_key_exists(1, $match) ? str_replace(',', '', $match[1]) : 0
        );
        
        $this->event->stat->similarweb_calculated($ranks);
        return $ranks;
    }
    
    public function calculate($vendor=null){
        if(!$vendor)
            return $this->show_404();
        
        $vendors = ['alexa', 'similarweb'];
        
        if(!in_array($vendor, $vendors))
            return $this->show_404();
        
        $ranks = $this->{'_calculate_' . $vendor}();
        if(!$ranks)
            return $this->redirect('/admin/stat/ranks');
        
        $cond = array(
            'vendor' => $vendor,
            'created' => (object)array('>=', date('Y-m-d'))
        );
        $old_rank = $this->Rank->getByCond($cond);
        
        if($old_rank){
            $this->Rank->set($old_rank->id, $ranks);
        }else{
            $ranks['vendor'] = $vendor;
            $this->Rank->create($ranks);
        }
        
        return $this->redirect('/admin/stat/ranks');
    }
    
    public function ranks(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-site_ranks'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Site Ranking'),
            'ranks' => array()
        );
        
        $this->load->model('Siteranks_model', 'Rank');
        
        $ranks_vendor = array('alexa', 'similarweb');
        foreach($ranks_vendor as $vendor){
            $ranks = $this->Rank->getBy('vendor', $vendor, 30);
            if(!$ranks)
                continue;
            
            $data_ranks = array();
            $max_rank_int = 0;
            $max_rank_loc = 0;
            foreach($ranks as $rank){
                $label = date('d M', strtotime($rank->created));
                $rank_int = $rank->rank_international;
                $rank_loc = $rank->rank_local;
                
                if($rank_int > $max_rank_int)
                    $max_rank_int = $rank_int;
                if($rank_loc > $max_rank_loc)
                    $max_rank_loc = $rank_loc;
                
                array_unshift($data_ranks, array(
                    'name' => $label,
                    'data' => array(
                        [ 'label' => $rank_int, 'value' => $rank_int, 'title' => 'International' ],
                        [ 'label' => $rank_loc, 'value' => $rank_loc, 'title' => 'Local' ]
                    )
                ));
            }
            
            // measure the size of each rank
            foreach($data_ranks as &$data_rank){
                $data_rank['data'][0]['value'] = 0 - round(( $data_rank['data'][0]['value'] / $max_rank_int ) * 100);
                $data_rank['data'][1]['value'] = 0 - round(( $data_rank['data'][1]['value'] / $max_rank_loc ) * 100);
            }
            
            $params['ranks'][$vendor] = $data_ranks;
        }
        
        $this->respond('stat/ranks', $params);
    }
    
    public function realtime(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-site_realtime'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Realtime Statistic'),
            'ga_token' => null
        );
        
        // google analytics
        if($this->setting->item('google_analytics_statistic')){
            $this->load->library('Google', '', 'google');
            $access_token = $this->google->get_analytics_token();
            $params['ga_token'] = $access_token;
            $params['ga_view'] = $this->setting->item('code_google_analytics_view');
        }
        
        $this->respond('stat/realtime', $params);
    }
    
    public function visitor(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-visitor_statistic'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Visitor Statistic'),
            'ga_token' => null,
            'ga_view' => null
        );
        
        // google analytics
        if($this->setting->item('google_analytics_statistic')){
            $this->load->library('Google', '', 'google');
            $access_token = $this->google->get_analytics_token();
            $params['ga_token'] = $access_token;
            $params['ga_view'] = $this->setting->item('code_google_analytics_view');
        }
        
        $this->respond('stat/visitor', $params);
    }
}