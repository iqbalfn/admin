<?php

if(!defined('BASEPATH'))
    die;

/**
 * The model of table `gallery_media`
 */
class Gallerymedia_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'gallery_media';

    /**
     * Constructor
     */
    function __construct(){
        $this->load->database();
        parent::__construct();
    }
}