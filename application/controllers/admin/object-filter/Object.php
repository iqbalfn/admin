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
        
        $rows = $this->db->like($field['field'], $query)->limit(20)->get($table);
        if(!$rows->num_rows())
            return $this->ajax(false, 'not found');
        
        $rows = $rows->result();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        $rows = $this->formatter->$table($rows);
        
        return $this->ajax($rows, false);
    }
}