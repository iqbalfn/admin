<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_category_chain`
 */
class Postcategorychain_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_category_chain';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}