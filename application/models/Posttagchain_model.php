<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_tag_chain`
 */
class Posttagchain_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_tag_chain';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}