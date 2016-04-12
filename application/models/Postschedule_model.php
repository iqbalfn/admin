<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `post_schedule`
 */
class Postschedule_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_schedule';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}