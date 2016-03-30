<?php

if(!defined('BASEPATH'))
    die;

class Object extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login');
        if(!$this->can_i('read-admin_page'))
            return $this->show_404();
        
        $params = array(
            'title' => _l('Admin'),
            'ranks' => array()
        );
        
        $this->load->model('Siteranks_model', 'Rank');
        
        $ranks_vendor = array('alexa', 'similarweb');
        foreach($ranks_vendor as $vendor){
            $ranks = $this->Rank->getBy('vendor', $vendor, 10);
            if(!$ranks)
                continue;
            
            $data_ranks = [
                'labels' => [],
                'datasets' => [
                    array(
                        'label' => 'Alexa Rank',
                        'fillColor' => 'rgba(220,220,220,0.2)',
                        'strokeColor' => 'rgba(220,220,220,1)',
                        'pointColor' => 'rgba(220,220,220,1)',
                        'pointStrokeColor' => '#fff',
                        'pointHighlightFill' => '#fff',
                        'pointHighlightStroke' => 'rgba(220,220,220,1)',
                        'data' => []
                    )
                ],
                'rank_international' => 0,
                'rank_local' => 0
            ];
            
            foreach($ranks as $rank){
                $label = date('d M', strtotime($rank->created));
                array_unshift($data_ranks['labels'], $label);
                array_unshift($data_ranks['datasets'][0]['data'], (0 - $rank->rank_international));
                
                if(!$data_ranks['rank_international'])
                    $data_ranks['rank_international'] = $rank->rank_international;
                if(!$data_ranks['rank_local'])
                    $data_ranks['rank_local'] = $rank->rank_local;
            }
            
            $params['ranks'][$vendor] = $data_ranks;
        }
        
        $this->respond('home/index', $params);
    }
}