<?php

if(!defined('BASEPATH'))
    die;

class MY_Model extends CI_Model
{
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
    
    /**
     * Implement condition
     * @param array cond The condition
     * @return $this
     */
    private function _implementCondition($cond){
        if(!is_array($cond))
            return $this;
        
        if(!count($cond))
            return $this;
        
        foreach($cond as $field => $value){
            if(is_array($value)){
                $this->db->where_in($field, $value);
                
            }elseif(is_object($value)){
                $value = (array)$value;
                $operator = $value[0];
                $wildcard = array_key_exists(2, $value) ? $value[2] : 'both';
                $value = $value[1];
                
                if(in_array($operator, array('>', '<', '!=', '=', '>=', '<=')))
                    $this->db->where("$field $operator", $value);
                elseif($operator == 'LIKE')
                    $this->db->like($field, $value, $wildcard);
                elseif($operator == 'NOT LIKE')
                    $this->db->not_like($field, $value, $wildcard);
                elseif($operator == 'IN')
                    $this->db->where_in($field, $value);
                elseif($operator == 'NOT IN')
                    $this->db->where_not_in($field, $value);
                
            }else{
                $this->db->where($field, $value);
                
            }
        }
        
        return $this;
    }
    
    /**
     * Implement order
     * @param array order field-order pair of order condition.
     * @return $this
     */
    private function _implementOrder($order){
        if(is_string($order))
            $order = [$order=>'DESC'];
        foreach($order as $field => $ord)
            $this->db->order_by($field, $ord);
        return $this;
    }
    
    /**
     * Implement paginatin 
     * @param integer total Total row to get.
     * @param integer page The page number.
     * @return $this
     */
    private function _implementPagination($total=1, $page=1){
        if($total === true)
            return $this;
        
        if($total === 1){
            $this->db->limit(1);
            return $this;
        }
        
        $page--;
        if($page < 0)
            $page = 0;
        
        $offset = $page * $total;
        
        $this->db->limit($total, $offset);
        
        return $this;
    }
    
    /**
     * Create new row
     * @param array row The row to insert
     * @return integer inserted id or false.
     */
    public function create($row){
        if($this->db->insert($this->table, $row))
            return $this->db->insert_id();
        return false;
    }
    
    /**
     * Create multiple rows at once.
     * @param array list of new rows to insert.
     * @return number of inserted row or false.
     */
    public function create_batch($rows){
        return $this->db->insert_batch($this->table, $rows);
    }
    
    /**
     * Get row(s) by id 
     * @param integer|array the row id or list of row ids.
     * @param integer total Total row to get. Default 1.
     * @param integer page Page number, default 1.
     * @param array order The order condition. Default id => DESC
     * @return object row or array list of object rows
     */
    public function get($id, $total=1, $page=1, $order=['id'=>'DESC']){
        return $this->getByCond(['id'=>$id], $total, $page, $order);
    }
    
    /**
     * Get row(s) by field
     * @param string field The field name for condition.
     * @param mixed|array value The field value or list of field value.
     * @param integer total Total number to get, default 1.
     * @param integer page The page number. Default 1.
     * @param array order The order condition
     * @return array list of object rows or object row
     */
    public function getBy($field, $value, $total=1, $page=1, $order=['id'=>'DESC']){
        return $this->getByCond([$field=>$value], $total, $page, $order);
    }
    
    /**
     * Get row(s) by condition.
     * @param array cond The selection condition.
     * @param integer total Total result expected. Default 1.
     * @param integer page The page number.
     * @param array order The order condition.
     * @return array list of rows or single row object.
     */
    public function getByCond($cond, $total=1, $page=1, $order=['id'=>'DESC']){
        $this
            ->_implementCondition($cond)
            ->_implementPagination($total, $page)
            ->_implementOrder($order);
        
        $rows = $this->db->get($this->table);
        
        if(!$rows->num_rows())
            return false;
        
        if($total == 1)
            return $rows->row();
        return $rows->result();
    }
}