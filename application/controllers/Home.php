<?php

if(!defined('BASEPATH'))
    die;

class Home extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    public function index(){
        $this->load->library('ObjectFormatter', '', 'format');
        
        $object = array(
            (object)array(
                'id'        => '1',
                'featured'  => 1,
                'private'   => false,
                'status'    => '1',
                'created'   => '2016-02-25 12:06:12',
                'slug'      => 'the-post-title',
                'cover'     => '/ab/ce/ajsdkfjalsdfhjeifjalsfjasdf.jpeg',
                'title'     => 'The Post Title',
                'content'   => 'Lorem <b>ipsum</b> dolor sit amet, consectetur adipiscing elit, <div></div>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user'      => '1'
            ),
            (object)array(
                'id'        => '2',
                'featured'  => 0,
                'private'   => true,
                'status'    => '2',
                'created'   => '2016-02-25 12:06:13',
                'slug'      => 'the-post-title-2',
                'cover'     => '/ab/ce/ajsfayuenfnnfeeee.jpeg',
                'title'     => 'The Post Title Second',
                'content'   => 'Lorem <b>ipsum</b> dolor sit amet, consectetur adipiscing elit, <div></div>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user'      => '2'
            ),
            (object)array(
                'id'        => '3',
                'featured'  => 0,
                'private'   => true,
                'status'    => '3',
                'created'   => '2016-02-25 12:06:14',
                'slug'      => 'the-post-title-4',
                'cover'     => '/ab/ce/ajsfayuendsafsffnnfeeee.jpeg',
                'title'     => 'The Post Title Third',
                'content'   => 'Lorem <b>ipsum</b> dolor sit amet, consectetur adipiscing elit, <div></div>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user'      => '3'
            )
        );
        
        $result = $this->format->post($object, false, ['user', 'category']);
        
        $this->ajax($result);
    }
}