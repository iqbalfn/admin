<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `banner`
 */
class Banner_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'banner';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}