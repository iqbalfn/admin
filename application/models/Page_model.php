<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `page`
 */
class Page_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'page';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}