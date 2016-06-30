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
        'name' => 'text',
        'seo_title' => 'text',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'gallery' => array(
        'cover' => 'media',
        'name' => 'text',
        'user' => '@parent[user]',
        'description' => 'text',
        'created' => 'date'
    ),
    
    'gallery_media' => array(
        'title' => 'text',
        'media' => 'media',
        'media_label' => 'text'
    ),
    
    'page' => array(
        'page' => 'join(/page/|$slug)',
        'title' => 'text',
        'content' => 'text',
        'created' => 'date',
        'seo_title' => 'text',
        'seo_schema' => 'enum',
        'seo_description' => 'text'
    ),
    
    'post' => array(
        'category' => '@chain[post_category]',
        'tag' => '@chain[post_tag]',
        'title' => 'text',
        'gallery' => '@parent[gallery]',
        'user' => '@parent[user]',
        'publisher' => '@parent[user]',
        'amp' => 'join(/post/amp/|$slug)',
        'page' => 'join(/post/read/|$slug)',
        'content' => 'text',
        'cover' => 'media',
        'status' => 'enum',
        'featured' => 'boolean',
        'editor_pick' => 'boolean',
        'seo_title' => 'text',
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
        'parent' => '@parent[post_category]',
        'created' => 'date',
        'name' => 'text',
        'content' => 'text',
        'seo_title' => 'text',
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
        'name' => 'text',
        'seo_title' => 'text',
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