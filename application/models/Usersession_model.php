<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `user_session`
 */
class Usersession_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'user_session';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}