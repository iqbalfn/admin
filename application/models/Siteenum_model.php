<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `enum`
 */
class Siteenum_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'site_enum';
    
    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}