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
        $post = $this->table;
        
        $this->db->select("$post.*");
        
        if(array_key_exists('q', $cond)){
            $this->db->like("$post.title", $cond['q']);
            unset($cond['q']);
        }
        
        if(array_key_exists('tag', $cond)){
            $this->load->model('Posttagchain_model', 'PTChain');
            $post_tag = $this->PTChain->table;
            $this->db->join($post_tag, "$post_tag.post = $post.id", 'LEFT');
            
            $method = is_array($cond['tag']) ? 'where_in' : 'where';
            $this->db->$method("$post_tag.post_tag", $cond['tag']);
            $this->db->group_by("$post_tag.post");
            unset($cond['tag']);
        }
        
        if(array_key_exists('category', $cond)){
            $this->load->model('Postcategorychain_model', 'PCChain');
            $post_category = $this->PCChain->table;
            $this->db->join($post_category, "$post_category.post = $post.id", 'LEFT');
            
            $method = is_array($cond['category']) ? 'where_in' : 'where';
            $this->db->$method("$post_category.post_category", $cond['category']);
            $this->db->group_by("$post_category.post");
            unset($cond['category']);
        }
        
        // let see the order in case it's ordered by `pageviews`, `sessions`, 
        // or `users` field which is in different table
        $new_order = [];
        $use_page_statistic = false;
        $page_statistic_fields = ['pageviews', 'sessions', 'users'];
        $this->load->model('Poststatistic_model', 'PStatistic');
        $post_statistic = $this->PStatistic->table;
        foreach($order as $field => $value){
            if(is_numeric($field)){
                $field = $value;
                $value = 'ASC';
            }
            
            if(in_array($field, $page_statistic_fields)){
                $use_page_statistic = true;
                $field = "$post_statistic.$field";
            }
            $new_order[$field] = $value;
        }
        $order = $new_order;
        
        if($use_page_statistic)
            $this->db->join($post_statistic, "$post_statistic.post = $post.id", 'INNER');
        
        return $this->getByCond($cond, $rpp, $page, $order);
    }
    
    /**
     * Count total by random condition
     * @param array cond The condition.
     */
    public function findByCondTotal($cond){
        $post = $this->table;
        
        if(array_key_exists('q', $cond)){
            $this->db->like($post . '.title', $cond['q']);
            unset($cond['q']);
        }
        
        if(array_key_exists('tag', $cond)){
            $this->load->model('Posttagchain_model', 'PTChain');
            $post_tag = $this->PTChain->table;
            $this->db->join($post_tag, "$post_tag.post = $post.id", 'LEFT');
            
            $method = is_array($cond['tag']) ? 'where_in' : 'where';
            $this->db->$method("$post_tag.post_tag", $cond['tag']);
            unset($cond['tag']);
        }
        
        if(array_key_exists('category', $cond)){
            $this->load->model('Postcategorychain_model', 'PCChain');
            $post_category = $this->PCChain->table;
            $this->db->join($post_category, "$post_category.post = $post.id", 'LEFT');
            
            $method = is_array($cond['category']) ? 'where_in' : 'where';
            $this->db->$method("$post_category.post_category", $cond['category']);
            unset($cond['category']);
        }
        
        return $this->countByCond($cond);
    }
}