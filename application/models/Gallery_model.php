<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `gallery`
 */
class Gallery_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'gallery';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}