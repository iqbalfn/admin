<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Object` controller
 */
class Object extends MY_Controller
{

    function __construct(){
        parent::__construct();
    }

    function index(){
        if(!$this->user)
            return $this->ajax(false, 'not authorized');
        
        $query = $this->input->get('q');
        $table = $this->input->get('table');
        
        $filterable_table = array(
            'banner'  => array('field' => 'name',       'perms' => 'read-banner'),
            'gallery' => array('field' => 'name',       'perms' => 'read-gallery'),
            'post'    => array('field' => 'title',      'perms' => 'read-post'),
            'post_tag'=> array('field' => 'name',       'perms' => 'read-post_tag'),
            'user'    => array('field' => 'fullname',   'perms' => 'read-user')
        );
        
        if(!array_key_exists($table, $filterable_table))
            return $this->ajax(false, 'not found');
        
        $field = $filterable_table[$table];
        
        if(!$this->can_i($field['perms']))
            return $this->ajax('not authorized');
        
        $model = ucfirst(str_replace('_', '', $table));
        $model_name = $model . '_model';
        $this->load->model($model_name, $model);
        
        $cond = array(
            $field['field'] => (object)['LIKE', $query]
        );
        $this->db->select( '`'. $table . '`.*, LENGTH(`'. $table . '`.`' . $field['field'] . '`) AS `strlen`', false );
        $rows = $this->$model->getByCond($cond, 20, false, ['strlen'=>'ASC']);
        if(!$rows)
            return $this->ajax(false, 'not found');
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $rows = $this->formatter->$table($rows);
        
        return $this->ajax($rows, false);
    }
}