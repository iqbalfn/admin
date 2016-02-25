<?php

$config['object_formatter'] = array(
    
    'post' => array(
        'id'            => 'integer',
        'featured'      => 'boolean',
        'private'       => 'delete',
        'status'        => 'enum',
        'created'       => 'date',
        'page'          => 'join(/post/read/|$id|/|$slug)',
        'cover'         => 'media',
        'title'         => 'string',
        'content'       => 'text',
        'category'      => '@chain[post_category]',
        'user'          => '@parent[user]',
        'member'        => '@member[post_red]'
    ),
    
    'post_category' => array(
        'id'            => 'integer',
        'user'          => '@parent[user]'
    ),
    
    'user' => array(
        'id'            => 'integer',
        'password'      => 'delete',
        'avatar'        => 'media',
        'created'       => 'date'
    )
);