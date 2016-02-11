<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `site_params`
 */
class Siteparams_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'site_params';

    /**
     * List of table field for formatter rule.
     * @var array
     */
    public $fields = [
       'id'      => 'integer',
       'created' => 'date'
    ];

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}