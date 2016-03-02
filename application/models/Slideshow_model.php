<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `slideshow`
 */
class Slideshow_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'slideshow';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}