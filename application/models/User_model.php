<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `user`
 */
class User_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'user';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
    
    /**
     * Find user by name
     * @param array condition, where 'q' key is used to match name or fullname.
     * @param integer rpp, result per page.
     * @param integer page, The page number.
     * @param array order, The order.
     */
    public function findByName($cond, $query, $rpp=12, $page=1, $order=['id'=>'DESC']){
        if($query){
            $this->db->group_start();
            $this->db->like('name', $query);
            $this->db->or_like('fullname', $query);
            $this->db->group_end();
        }
        
        return $this->getByCond($cond, $rpp, $page, $order);
    }
    
    /**
     * Find total result by condition.
     * @param array cond The condition.
     */
    public function findByNameTotal($cond, $query){
        if($query){
            $this->db->group_start();
            $this->db->like('name', $query);
            $this->db->or_like('fullname', $query);
            $this->db->group_end();
        }
        
        return $this->countByCond($cond);
    }
}