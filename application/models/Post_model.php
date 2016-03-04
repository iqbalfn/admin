<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post`
 */
class Post_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}