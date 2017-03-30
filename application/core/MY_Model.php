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
     * Set active database to current model db 
     */
    private function _setModelDB(){
        if(!$this->db->multiple)
            return;
        
        if(!property_exists($this, 'dbname')){
            if(!file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php') && !file_exists($file_path = APPPATH.'config/database.php'))
                show_error('The configuration file database.php does not exist.');
            include($file_path);
            $this->dbname = $db['default']['database'];
        }
        
        if($this->db->database != $this->dbname)
            $this->db->db_select($this->dbname);
        return $this;
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
        
        $table = $this->table;
        foreach($cond as $field => $value){
            if(is_array($value)){
                $this->db->where_in("`$table`.`$field`", $value);
                
            }elseif(is_object($value)){
                $value = (array)$value;
                $operator = $value[0];
                $wildcard = array_key_exists(2, $value) ? $value[2] : 'both';
                $value = $value[1];
                
                if(in_array($operator, array('>', '<', '!=', '=', '>=', '<=', 'IS NOT', 'IS')))
                    $this->db->where("`$table`.`$field` $operator", $value);
                elseif($operator == 'LIKE')
                    $this->db->like("`$table`.`$field`", $value, $wildcard);
                elseif($operator == 'NOT LIKE')
                    $this->db->not_like("`$table`.`$field`", $value, $wildcard);
                elseif($operator == 'IN')
                    $this->db->where_in("`$table`.`$field`", $value);
                elseif($operator == 'NOT IN')
                    $this->db->where_not_in("`$table`.`$field`", $value);
                
            }else{
                $this->db->where("`$table`.`$field`", $value);
                
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
        
        $table = $this->table;
        foreach($order as $field => $ord){
            if(strstr($table, '.') !== false)
                $field = "`$table`.`$field`";
            $this->db->order_by($field, $ord);
        }
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
     * Set table index
     * @param integer index The index number
     * @return $this
     */
    public function setTableIndex($index){
        $index = (string)$index;
        $valid_index = substr($index, -1);
        $this->table = $this->table_index . '_' . $valid_index;
    }
    
    /**
     * Get avg value of field.
     * @param string field The field name to calculate.
     * @return integer average or false.
     */
    public function avg($field){
        return $this->avgByCond([], $field);
    }
    
    /**
     * Get avg value of field by field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to calculate.
     * @return integer average number or false.
     */
    public function avgBy($where_field, $value, $field){
        return $this->avgByCond([$where_field=>$value], $field);
    }
    
    /**
     * Get avg value of field by field.
     * @param array cond The conditions.
     * @param string field The field name to calculate.
     * @return integer avg number or false.
     */
    public function avgByCond($cond, $field){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->select_avg($field);
        
        $result = $this->db->get($this->table);
        
        if(!$result->num_rows())
            return false;
        return $result->row()->$field;
    }
    
    /**
     * Get total rows
     * @return integer total rows or false.
     */
    public function count(){
        return $this->countByCond([]);
    }
    
    /**
     * Get total rows by fields
     * @param string field The field for condition.
     * @param mixed|array value The row `$field` value or list of `$field` values.
     * @return integer total rows or false.
     */
    public function countBy($field, $value){
        return $this->countByCond([$field=>$value]);
    }
    
    /**
     * Get total rows by conditions
     * @param array cond The conditions.
     * @return integer total rows or false.
     */
    public function countByCond($cond){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get total rows
     * @param string field The field to group by
     * @return array field-total pair of the result
     */
    public function countGrouped($field){
        return $this->countGroupedByCond([], $field);
    }
    
    /**
     * Get total rows by fields
     * @param string where_field The field for condition
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field for condition.
     * @return array field-total pair of the result
     */
    public function countGroupedBy($where_field, $value, $field){
        return $this->countGroupedByCond([$field=>$value], $field);
    }
    
    /**
     * Get total rows by conditions
     * @param array cond The conditions.
     * @param string field The field to calculate as key.
     * @return array field-total pair of the result
     */
    public function countGroupedByCond($cond, $field){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->select("$field, COUNT(*) AS total");
        $this->db->group_by($field);
        
        $result = $this->db->get($this->table);
        if(!$result->num_rows())
            return false;
        return prop_as_key($result->result(), $field, 'total');
    }
    
    /**
     * Create new row
     * @param array row The row to insert
     * @return integer inserted id or false.
     */
    public function create($row){
        $this->_setModelDB();
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
        $this->_setModelDB();
        return $this->db->insert_batch($this->table, $rows);
    }
    
    /**
     * Decrease table field by 1 by id.
     * @param integer|array id The row id or list of row id.
     * @param string field The field name to update.
     * @param integer total Total number the field to decrease.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function dec($id, $field, $total=1, $update_field=false){
        return $this->decByCond(['id'=>$id], $field, $total, $update_field);
    }
    
    /**
     * Decrease table field by 1 by table field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to update.
     * @param integer total Total number the field to decrease.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function decBy($where_field, $value, $field, $total=1, $update_field=false){
        return $this->decByCond([$where_field=>$value], $field, $total, $update_field);
    }
    
    /**
     * Decrease table field by 1 by conditions
     * @param array cond The conditions.
     * @param string field The field name to update.
     * @param integer total Total number the field to decrease.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function decByCond($cond, $field, $total=1, $update_field=false){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->set($field, "$field-$total", false);
        if($update_field)
            $this->db->set('updated', date('Y-m-d H:i:s'));
        return $this->db->update($this->table);
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
        $this->_setModelDB();
        $this
            ->_implementCondition($cond)
            ->_implementPagination($total, $page)
            ->_implementOrder($order);
        
        $rows = $this->db->get($this->table);
        
        if(!$rows->num_rows())
            return false;
        
        if($total === 1)
            return $rows->row();
        return $rows->result();
    }
    
    /**
     * Increase table field by 1 by id.
     * @param integer|array id The row id or list of row id.
     * @param string field The field name to update.
     * @param integer total Total number the field to increase.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function inc($id, $field, $total=1, $update_field=false){
        return $this->incByCond(['id'=>$id], $field, $total, $update_field);
    }
    
    /**
     * Increase table field by 1 by table field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to update.
     * @param integer total Total number the field to increase.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function incBy($where_field, $value, $field, $total=1, $update_field=false){
        return $this->incByCond([$where_field=>$value], $field, $total, $update_field);
    }
    
    /**
     * Increase table field by 1 by conditions
     * @param array cond The conditions.
     * @param string field The field name to update.
     * @param integer total Total number the field to increase.
     * @param boolean update_field Update the `updated` field.
     * @return true on success, false otherwise.
     */
    public function incByCond($cond, $field, $total=1, $update_field=false){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->set($field, "$field+$total", false);
        if($update_field)
            $this->db->set('updated', date('Y-m-d H:i:s'));
        return $this->db->update($this->table);
    }
    
    /**
     * Get max value of field.
     * @param string field The field name to select.
     * @return integer max number or false.
     */
    public function max($field){
        return $this->maxByCond([], $field);
    }
    
    /**
     * Get max value of field by field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to calculate.
     * @return integer max number or false.
     */
    public function maxBy($where_field, $value, $field){
        return $this->maxByCond([$where_field=>$value], $field);
    }
    
    /**
     * Get max value of field by field.
     * @param array cond The conditions.
     * @param string field The field name to calculate.
     * @return integer max number or false.
     */
    public function maxByCond($cond, $field){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->select_max($field);
        
        $result = $this->db->get($this->table);
        
        if(!$result->num_rows())
            return false;
        return $result->row()->$field;
    }
    
    /**
     * Get min value of field.
     * @param string field The field name to select.
     * @return integer min number or false.
     */
    public function min($field){
        return $this->minByCond([], $field);
    }
    
    /**
     * Get min value of field by field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to calculate.
     * @return integer min number or false.
     */
    public function minBy($where_field, $value, $field){
        return $this->minByCond([$where_field=>$value], $field);
    }
    
    /**
     * Get min value of field by field.
     * @param array cond The conditions.
     * @param string field The field name to calculate.
     * @return integer min number or false.
     */
    public function minByCond($cond, $field){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->select_min($field);
        
        $result = $this->db->get($this->table);
        
        if(!$result->num_rows())
            return false;
        return $result->row()->$field;
    }
    
    /**
     * Remove row by id.
     * @param integer|array id The row id or list of row id.
     * @return true on success, false otherwise.
     */
    public function remove($id){
        return $this->removeByCond(['id'=>$id]);
    }
    
    /**
     * Remove rows by table field.
     * @param string field The field name.
     * @param mixed|array value The field value for selection.
     * @return true on success, false otherwise.
     */
    public function removeBy($field, $value){
        return $this->removeByCond([$field=>$value]);
    }
    
    /**
     * Remove table by conditions
     * @param array cond The conditions.
     * @param string fields field-value pair of new data to update to table
     * @return true on success, false otherwise.
     */
    public function removeByCond($cond){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        return $this->db->delete($this->table);
    }
    
    /**
     * Update table by id.
     * @param integer|array id The row id or list of row id.
     * @param array fields field-value pair of the new row data to update.
     * @return true on success, false otherwise.
     */
    public function set($id, $fields){
        return $this->setByCond(['id'=>$id], $fields);
    }
    
    /**
     * Update table by table field.
     * @param string field The field name.
     * @param mixed|array value The field value for selection.
     * @param array fields field-value pair of new data to update to table.
     * @return true on success, false otherwise.
     */
    public function setBy($field, $value, $fields){
        return $this->setByCond([$field=>$value], $fields);
    }
    
    /**
     * Update table by conditions
     * @param array cond The conditions.
     * @param string fields field-value pair of new data to update to table
     * @return true on success, false otherwise.
     */
    public function setByCond($cond, $fields){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        return $this->db->update($this->table, $fields);
    }
    
    /**
     * Get sum value of field.
     * @param string field The field name to calculate.
     * @return integer sum or false.
     */
    public function sum($field){
        return $this->sumByCond([], $field);
    }
    
    /**
     * Get sum value of field by field.
     * @param string where_field The field for condition.
     * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
     * @param string field The field name to calculate.
     * @return integer sum number or false.
     */
    public function sumBy($where_field, $value, $field){
        return $this->sumByCond([$where_field=>$value], $field);
    }
    
    /**
     * Get sum value of field by field.
     * @param array cond The conditions.
     * @param string field The field name to calculate.
     * @return integer sum number or false.
     */
    public function sumByCond($cond, $field){
        $this->_setModelDB();
        $this->_implementCondition($cond);
        $this->db->select_sum($field);
        
        $result = $this->db->get($this->table);
        
        if(!$result->num_rows())
            return false;
        return $result->row()->$field;
    }
    
    /**
     * Truncate table
     */
    public function truncate(){
        $this->_setModelDB();
        return $this->db->truncate($this->table);
    }
}