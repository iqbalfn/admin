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
     * @param array list of data to replace
     */
    public function update($data){
        if(!count($data))
            return false;
        
        $qry = 'REPLACE `' . $this->table . '` ( `post`, `pageviews`, `users`, `sessions` ) VALUES ';
        $ros = [];
        foreach($data as $row){
            if(array_key_exists('post', $row))
                $ros[] = "( $row[post], $row[pageviews], $row[users], $row[sessions] )";
        }
        
        $qry.= implode(', ', $ros);
        
        $this->db->query($qry);
    }
}