<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `event`
 */
class Event_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'event';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}