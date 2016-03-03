<?php

$config['object_formatter'] = array(
    
    'banner' => array(
        'media' => 'media',
        'expired' => 'date'
    ),
    
    'gallery' => array(
        'cover' => 'media'
    ),
    
    'gallery_media' => array(
        'media' => 'media'
    ),
    
    'page' => array(
        'page' => 'join(/page/|$slug)',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'slideshow' => array(
        'image' => 'media'
    )
);