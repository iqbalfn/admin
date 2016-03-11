<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post`
 */
class Post_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
    
    /**
     * Filter post by random condition
     * @param array cond The condition.
     * @param integer total Result per page.
     * @param integer page Page number.
     * @param array order The order condition.
     */
    public function findByCond($cond, $rpp=12, $page=1, $order=['id'=>'DESC']){
        $this->db->select('post.*');
        
        $post = $this->table;
        
        if(array_key_exists('q', $cond))
            $this->db->like('post.title', $cond['q']);
        if(array_key_exists('status', $cond))
            $this->db->where('post.status', $cond['status']);
        if(array_key_exists('user', $cond))
            $this->db->where('post.user', $cond['user']);
        
        if(array_key_exists('tag', $cond)){
            $this->load->model('Posttagchain_model', 'PTChain');
            $post_tag = $this->PTChain->table;
            $this->db->join($post_tag, "$post_tag.post = $post.id", 'LEFT');
            
            $this->db->where("$post_tag.post_tag", $cond['tag']);
        }
        
        if(array_key_exists('category', $cond)){
            $this->load->model('Postcategorychain_model', 'PCChain');
            $post_category = $this->PCChain->table;
            $this->db->join($post_category, "$post_category.post = $post.id", 'LEFT');
            
            $this->db->where("$post_category.post_category", $cond['category']);
        }
        
        return $this->getByCond([], $rpp, $page, $order);
    }
}