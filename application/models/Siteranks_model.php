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
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}