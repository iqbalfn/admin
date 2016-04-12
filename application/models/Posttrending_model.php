<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_trending`
 */
class Posttrending_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_trending';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}