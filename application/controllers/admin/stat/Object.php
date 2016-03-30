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
        
        return $ranks;
    }
    
    public function _calculate_similarweb(){
        $uri = 'https://www.similarweb.com/website/' . base_url();
        
        $cu = curl_init($uri);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
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
            return $this->redirect('/admin');
        
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
        
        return $this->redirect('/admin');
    }
}