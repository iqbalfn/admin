<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `site_ranks`
 */
class Siteranks_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'site_ranks';

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