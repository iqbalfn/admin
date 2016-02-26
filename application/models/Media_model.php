<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `media`
 */
class Media_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'media';
    
    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}