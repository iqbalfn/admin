<?php

$config['object_formatter'] = array(
    
    'banner' => array(
        'media' => 'media',
        'expired' => 'date'
    ),
    
    'gallery' => array(
        'cover' => 'media',
        'page' => 'join(/gallery/|$slug)',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'gallery_media' => array(
        'media' => 'media',
        'page' => 'join(/gallery/|$gallery.slug|/|$id)',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'page' => array(
        'page' => 'join(/page/|$slug)',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post_category' => array(
        'page' => 'join(/post/category/|$slug)',
        'description' => 'text',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post_tag' => array(
        'page' => 'join(/post/tag/|$slug)',
        'description' => 'text',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'slideshow' => array(
        'image' => 'media'
    ),
    
    'user' => array(
        'avatar' => 'media',
        'status' => 'enum'
    )
);