<?php

$config = array(

    '/admin/enum' => array(
    
        'group' => array(
            'field' => 'group',
            'label' => 'Group',
            'rules' => 'required|strtolower',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'value' => array(
            'field' => 'value',
            'label' => 'Value',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'label' => array(
            'field' => 'label',
            'label' => 'Label',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        )
        
    ),
    
    '/admin/me/login' => array(
    
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|strtolower',
            'input' => array(
                'type' => 'text',
                'label'=> false
            )
        ),
        
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            'input' => array(
                'type' => 'password',
                'label'=> false
            )
        )
    ),
    
    '/admin/me/setting' => array(
        
        'about' => array(
            'field' => 'about',
            'label' => 'About',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        ),
        
        'avatar' => array(
            'field' => 'avatar',
            'label' => 'Avatar',
            'rules' => '',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'fullname' => array(
            'field' => 'fullname',
            'label' => 'Fullname',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|strtolower|alpha_dash',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'min_length[6]',
            'input' => array(
                'type' => 'password'
            )
        ),
        
        'website' => array(
            'field' => 'website',
            'label' => 'Website',
            'rules' => 'valid_url',
            'input' => array(
                'type' => 'url'
            )
        )
    ),
    
    '/admin/param' => array(
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|strtolower|alpha_dash',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'value' => array(
            'field' => 'value',
            'label' => 'Value',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        )
    )
);