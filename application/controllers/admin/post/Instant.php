<?php

if(!defined('BASEPATH'))
    die;

/**
 * The 'Instant' controller
 */
class Instant extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Post_model', 'Post');
    }
    
    public function clear(){
        $params = array(
            'title' => _l('Clear Instant Content'),
            'total' => 0
        );
        
        $total = $this->Post->countByCond(['instant_content' => (object)['IS NOT', null]]);
        $params['total'] = $total;
        
        if($total)
            $this->Post->setByCond([], ['instant_content'=>NULL]);
        
        $this->event->post_instant->cleared();
        $this->respond('post/instant/clear', $params);
    }
}