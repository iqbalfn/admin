<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_category`
 */
class Postcategory_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_category';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}