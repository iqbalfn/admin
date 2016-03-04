<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `perms`
 */
class Perms_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'perms';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}