<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_selection`
 */
class Postselection_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_selection';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}