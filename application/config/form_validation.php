<?php

$config = array(
    
    '/admin/banner' => array(
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'media' => array(
            'field' => 'media',
            'label' => 'Media',
            'rules' => 'required|media',
            'input' => array(
                'type' => 'file',
                'file_type' => 'jpg|jpeg|png|bmp|gif|mov|mp4|mpeg|mkv'
            )
        ),
        
        'link' => array(
            'field' => 'link',
            'label' => 'Link',
            'rules' => 'required',
            'input' => array(
                'type' => 'url'
            )
        ),
        
        'expired' => array(
            'field' => 'expired',
            'label' => 'Expired',
            'rules' => 'required',
            'input' => array(
                'type' => 'datetime'
            )
        )
    ),
    
    '/admin/gallery' => array(
        
        'cover' => array(
            'field' => 'cover',
            'label' => 'Cover',
            'rules' => 'required|media',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[gallery.slug,3]',
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
            'rules' => 'media',
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
            'rules' => 'media',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'email' => array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|is_unique[user.email,0]',
            'input' => array(
                'type' => 'email'
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
            'rules' => 'required|strtolower|alpha_dash|is_unique[user.name,0]',
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
    
    '/admin/page' => array(
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[page.slug,3]',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'class' => 'slugify',
                    'data-source' => '#field-title'
                )
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
        
        'content' => array(
            'field' => 'content',
            'label' => 'Content',
            'rules' => '',
            'input' => array(
                'type' => 'tinymce'
            )
        ),
        
        'seo_schema' => array(
            'field' => 'seo_schema',
            'label' => 'Schema',
            'rules' => '',
            'input' => array(
                'type' => 'select'
            )
        ),
        
        'seo_title' => array(
            'field' => 'seo_title',
            'label' => 'Meta Title',
            'rules' => '',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'seo_description' => array(
            'field' => 'seo_description',
            'label' => 'Meta Description',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        ),
        
        'seo_keywords' => array(
            'field' => 'seo_keywords',
            'label' => 'Meta Keywords',
            'rules' => '',
            'input' => array(
                'type' => 'tag'
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
            'rules' => 'required|media',
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
        
    ),
    
    '/admin/user' => array(
        
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
            'rules' => 'media',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'email' => array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|is_unique[user.email,3]',
            'input' => array(
                'type' => 'email'
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
            'rules' => 'required|strtolower|alpha_dash|is_unique[user.name,3]',
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
        ),
        
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => '',
            'input' => array(
                'type' => 'select'
            )
        )
    )
);