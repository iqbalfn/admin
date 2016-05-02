<?php

$config['object_formatter'] = array(
    
    'banner' => array(
        'media' => 'media',
        'expired' => 'date'
    ),
    
    'event' => array(
        'cover' => 'media',
        'page' => 'join(/event/|$slug)',
        'content' => 'text',
        'date' => 'date',
        'created' => 'date',
        'location' => 'location',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'gallery' => array(
        'cover' => 'media',
        'name' => 'text',
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
        'title' => 'text',
        'gallery' => '@parent[gallery]',
        'user' => '@parent[user]',
        'amp' => 'join(/post/amp/|$slug)',
        'page' => 'join(/post/read/|$slug)',
        'content' => 'text',
        'cover' => 'media',
        'status' => 'enum',
        'featured' => 'boolean',
        'editor_pick' => 'boolean',
        'seo_schema' => 'enum',
        'seo_description' => 'text',
        'embed' => 'embed',
        'created' => 'date',
        'published' => 'date',
        'updated' => 'date'
    ),
    
    'post_category' => array(
        'page' => 'join(/post/category/|$slug)',
        'description' => 'text',
        'updated' => 'date',
        'created' => 'date',
        'content' => 'text',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post_schedule' => array(
        'post' => '@parent[post]'
    ),
    
    'post_selection' => array(
        'post' => '@parent[post]'
    ),
    
    'post_suggestion' => array(
        'title' => 'text'
    ),
    
    'post_tag' => array(
        'page' => 'join(/post/tag/|$slug)',
        'description' => 'text',
        'updated' => 'date',
        'created' => 'date',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'slideshow' => array(
        'image' => 'media',
        'title' => 'text'
    ),
    
    'user' => array(
        'avatar' => 'media',
        'about' => 'text',
        'status' => 'enum',
        'created' => 'date',
        'password' => 'delete',
        'page' => 'join(/user/|$name)'
    )
);