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
     * List of table field for formatter rule.
     * @var array
     */
    public $fields = [
       'id'      => 'integer',
       'created' => 'date'
    ];

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}