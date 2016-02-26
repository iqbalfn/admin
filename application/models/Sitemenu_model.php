<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `site_menu`
 */
class Sitemenu_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'site_menu';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}