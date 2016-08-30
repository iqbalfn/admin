<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_trending`
 */
class Posttrending_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_trending';

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
        $this->load->model('Post_model', 'Post');
        
        $post = $this->Post->table;
        $post_trending = $this->table;
        
        $this->db->select("$post.*");
        $this->db->join($post_trending, "$post_trending.post = $post.id");
        
        // TODO advance where clouse
        if(array_key_exists('tag', $cond)){
            $this->db->where("$post_trending.tag", $cond['tag']);
            unset($cond['tag']);
        }
        
        // TODO advance where clouse
        if(array_key_exists('category', $cond)){
            $this->db->where("$post_trending.category", $cond['category']);
            unset($cond['category']);
        }
        
        $this->db->group_by("$post.id");
        
        return $this->Post->getByCond($cond, $rpp, $page, $order);
    }
    
    /**
     * Total post trending by cond
     * @param array cond The condition
     */
    public function findByCondTotal($cond){
        $this->load->model('Post_model', 'Post');
        
        $post = $this->Post->table;
        $post_trending = $this->table;
        
        $this->db->join($post_trending, "$post_trending.post = $post.id");
        
        // TODO advance where clouse
        if(array_key_exists('tag', $cond)){
            $this->db->where("$post_trending.tag", $cond['tag']);
            unset($cond['tag']);
        }
        
        // TODO advance where clouse
        if(array_key_exists('category', $cond)){
            $this->db->where("$post_trending.category", $cond['category']);
            unset($cond['category']);
        }
        
        return $this->Post->countByCond($cond);
    }
}