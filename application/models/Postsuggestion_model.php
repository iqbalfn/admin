<?php

if(!defined('BASEPATH'))
   die;

/**
 * The model of table `post_suggestion`
 */
class Postsuggestion_model extends MY_Model
{
    /**
     * Table name
     * @var string
     */
    public $table = 'post_suggestion';

   /**
    * Constructor
    */
   function __construct(){
        $this->load->database();
        parent::__construct();
    }
}