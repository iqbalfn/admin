<?php

if(!defined('BASEPATH'))
   die;

/**
 * The model of table `post_statistic`
 */
class Poststatistic_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_statistic';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
    
    /**
     * Replace exists data 
     * @param array the row object
     */
    public function incStat($data){
        foreach($data as $field => $value){
            if($field == 'post')
                $this->db->where('post', $value);
            else
                $this->db->set($field, "$field+$value", false);
        }
        
        return $this->db->update($this->table);
    }
}