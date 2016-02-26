<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `user_perms`
 */
class Userperms_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'user_perms';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}