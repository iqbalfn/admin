<?php

$config = array(
    
    '/admin/gallery' => array(
        
        'cover' => array(
            'field' => 'cover',
            'label' => 'Cover',
            'rules' => 'required',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'class' => 'slugify',
                    'data-source' => '#field-name'
                )
            )
        ),
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        )
        
    ),
    
    '/admin/gallery/media' => array(
        
        'media' => array(
            'field' => 'media',
            'label' => 'Media',
            'rules' => '',
            'input' => array(
                'type' => 'file',
                'file_type' => 'gif|png|jpg|jpeg|bmp|avi|mp4|mpeg|mov|mkv'
            )
        ),
        
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
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

    '/admin/setting/enum' => array(
    
        'group' => array(
            'field' => 'group',
            'label' => 'Group',
            'rules' => 'required|strtolower',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'readonly' => 'readonly'
                )
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
    
    '/admin/setting/menu' => array(
        
        'group' => array(
            'field' => 'group',
            'label' => 'Group',
            'rules' => 'required',
            'input' => array(
                'type' => 'text',
                'attrs'=> array(
                    'readonly' => 'readonly'
                )
            )
        ),
        
        'label' => array(
            'field' => 'label',
            'label' => 'Label',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'url' => array(
            'field' => 'url',
            'label' => 'URL',
            'rules' => '',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'index' => array(
            'field' => 'index',
            'label' => 'Index',
            'rules' => 'is_natural_no_zero',
            'input' => array(
                'type' => 'number'
            )
        ),
        
        'parent' => array(
            'field' => 'parent',
            'label' => 'Parent',
            'rules' => '',
            'input' => array(
                'type' => 'parent'
            )
        )
        
    ),
    
    '/admin/setting/param' => array(
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|strtolower|alpha_dash',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'readonly' => (ci()->uri->segment(4) > 0 ? 'readonly' : false)
                )
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
    ),
    
    
    '/admin/setting/slideshow' => array(
    
        'group' => array(
            'field' => 'group',
            'label' => 'Group',
            'rules' => 'required',
            'input' => array(
                'type' => 'text',
                'attrs'=> array(
                    'readonly' => 'readonly'
                )
            )
        ),
        
        'image' => array(
            'field' => 'image',
            'label' => 'Image',
            'rules' => 'required',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'link' => array(
            'field' => 'link',
            'label' => 'URL',
            'rules' => '',
            'input' => array(
                'type' => 'url'
            )
        ),
        
        'index' => array(
            'field' => 'index',
            'label' => 'Index',
            'rules' => 'is_natural_no_zero',
            'input' => array(
                'type' => 'number'
            )
        ),
        
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        )
        
    )
);