<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `user`
 */
class User_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'user';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}