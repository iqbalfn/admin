<?php

$config = array(
    
    'test/form' => array(
    
        'email' => array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required',
            'input' => array(
                'type' => 'email',
                'attrs' => array(
                    'id' => 'lorem-ipsum',
                    'class' => ['the-lorem-ipsum']
                )
            )
        ),
        
        'no-label' => array(
            'field' => 'no-label',
            'label' => 'No Label',
            'rules' => 'required',
            'input' => array(
                'type' => 'text',
                'label'=> false
            )
        ),
        
        'with-error' => array(
            'field' => 'with-error',
            'label' => 'With Label',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
    
        'number' => array(
            'field' => 'number',
            'label' => 'Number',
            'rules' => 'required|less_than[10]|greater_than[2]',
            'input' => array(
                'type' => 'number'
            )
        ),
    
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            'input' => array(
                'type' => 'password'
            )
        ),
    
        'search' => array(
            'field' => 'search',
            'label' => 'Search',
            'rules' => 'required',
            'input' => array(
                'type' => 'search'
            )
        ),
    
        'search-prefixed' => array(
            'field' => 'search-prefixed',
            'label' => 'Search Prefixed',
            'rules' => 'required',
            'input' => array(
                'type' => 'search',
                'prefix' => 'Lorem Ipsum'
            )
        ),
    
        'tel' => array(
            'field' => 'tel',
            'label' => 'Tel',
            'rules' => 'required',
            'input' => array(
                'type' => 'tel'
            )
        ),
    
        'text' => array(
            'field' => 'text',
            'label' => 'Text',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
    
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required',
            'input' => array(
                'type' => 'text',
                'prefix'=> base_url('/post/read') . '/'
            )
        ),
    
        'url' => array(
            'field' => 'url',
            'label' => 'URL',
            'rules' => 'required',
            'input' => array(
                'type' => 'url'
            )
        ),
    
        'color' => array(
            'field' => 'color',
            'label' => 'Color',
            'rules' => 'required',
            'input' => array(
                'type' => 'color'
            )
        ),
    
        'date' => array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'required',
            'input' => array(
                'type' => 'date'
            )
        ),
    
        'datetime' => array(
            'field' => 'datetime',
            'label' => 'Datetime',
            'rules' => 'required',
            'input' => array(
                'type' => 'datetime'
            )
        ),
    
        'month' => array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'required',
            'input' => array(
                'type' => 'month'
            )
        ),
    
        'time' => array(
            'field' => 'time',
            'label' => 'Time',
            'rules' => 'required',
            'input' => array(
                'type' => 'time'
            )
        ),
    
        'range' => array(
            'field' => 'range',
            'label' => 'Range',
            'rules' => 'required',
            'input' => array(
                'type' => 'range'
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
    
        'textarea' => array(
            'field' => 'textarea',
            'label' => 'Textarea',
            'rules' => 'required',
            'input' => array(
                'type' => 'textarea'
            )
        ),
    
        'tinymcelen' => array(
            'field' => 'tinymcelen',
            'label' => 'Tinymce',
            'rules' => 'required',
            'input' => array(
                'type' => 'tinymce'
            )
        ),
    
        'select' => array(
            'field' => 'select',
            'label' => 'Select',
            'rules' => 'required',
            'input' => array(
                'type' => 'select'
            )
        ),
    
        'boolean' => array(
            'field' => 'boolean',
            'label' => 'Boolean',
            'rules' => 'required',
            'input' => array(
                'type' => 'boolean'
            )
        ),
    
        'file' => array(
            'field' => 'file',
            'label' => 'File',
            'rules' => 'required',
            'input' => array(
                'type' => 'file',
                'file_type' => 'doc|pdf'
            )
        ),
    
        'multiple' => array(
            'field' => 'multiple',
            'label' => 'Multiple',
            'rules' => 'required',
            'input' => array(
                'type' => 'multiple'
            )
        )
    )
);