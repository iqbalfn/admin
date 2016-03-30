<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `url_redirection`
 */
class Urlredirection_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'url_redirection';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}