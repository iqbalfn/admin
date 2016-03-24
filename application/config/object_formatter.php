<?php

$config['object_formatter'] = array(
    
    'banner' => array(
        'media' => 'media',
        'expired' => 'date'
    ),
    
    'gallery' => array(
        'cover' => 'media',
        'page' => 'join(/gallery/|$slug)',
        'description' => 'text',
        'created' => 'date',
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
        'content' => 'text',
        'created' => 'date',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post' => array(
        'category' => '@chain[post_category]',
        'tag' => '@chain[post_tag]',
        'gallery' => '@parent[gallery]',
        'user' => '@parent[user]',
        'page' => 'join(/post/read/|$slug)',
        'content' => 'text',
        'cover' => 'media',
        'status' => 'enum',
        'featured' => 'boolean',
        'editor_pick' => 'boolean',
        'seo_schema' => 'enum',
        'seo_description' => 'text',
        'created' => 'date',
        'published' => 'date'
    ),
    
    'post_category' => array(
        'page' => 'join(/post/category/|$slug)',
        'description' => 'text',
        'created' => 'date',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post_selection' => array(
        'post' => '@parent[post]'
    ),
    
    'post_tag' => array(
        'page' => 'join(/post/tag/|$slug)',
        'description' => 'text',
        'created' => 'date',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'slideshow' => array(
        'image' => 'media'
    ),
    
    'user' => array(
        'avatar' => 'media',
        'about' => 'text',
        'status' => 'enum',
        'created' => 'date',
        'page' => 'join(/user/|$name)'
    )
);