<?php

$config['object_meta'] = array(
    
    'event' => array(
        'canonical'             => 'page|object_property|base_url',
        'description'           => ['seo_description->clean()|object_property', 'content->chars(160)|object_property'],
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => 'cover|object_property',
        'og:title'              => '@title',
        'og:type'               => 'website',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property', 'name->clean()|object_property'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => 'cover|object_property',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical',
    ),
    
    'home' => array(
        'canonical'             => '/|base_url|implement_url_pagination',
        'description'           => 'site_frontpage_description|setting->item|implement_title_pagination',
        'keywords'              => 'site_frontpage_keywords|setting->item',
        'og:description'        => '@description',
        'og:image'              => '/static/image/logo/logo.png|theme->asset',
        'og:title'              => '@title',
        'og:type'               => 'website',
        'og:url'                => '@canonical',
        'title'                 => 'site_frontpage_title|setting->item|implement_title_pagination',
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical'
    ),
    
    'page' => array(
        'canonical'             => 'page|object_property|base_url',
        'description'           => ['seo_description->clean()|object_property', 'content->chars(160)|object_property'],
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => '/static/image/logo/logo.png|theme->asset',
        'og:title'              => '@title',
        'og:type'               => 'website',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property', 'title->clean()|object_property'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical'
    ),
    
    'post'                      => array(
//         'article:author'        => '...',
        'article:modified_time' => 'updated->format(c)|object_property',
        'article:published_time'=> 'published->format(c)|object_property',
        'article:section'       => 'category|object_property|prop_values($,name)|current($)',
        'article:tag'           => 'tag|object_property|prop_values($,name)',
        'article:publisher'     => 'code_facebook_page_id|setting->item',
        'canonical'             => 'page|object_property|base_url|implement_url_pagination',
        'description'           => ['seo_description->clean()|object_property|implement_title_pagination', 'content->chars(160)|object_property|implement_title_pagination'],
//         'fb:admins'             => '...',
        'fb:profile_id'         => '',
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => 'cover|object_property',
        'og:title'              => '@title',
        'og:type'               => 'article',
        'og:updated_time'       => '@article:modified_time',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property|implement_title_pagination', 'title->clean()|object_property|implement_title_pagination'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical',
        'ga:group'              => 'ga_group|object_property',
        'amphtml'               => 'amp|object_property|base_url'
    ),
    
    'post_amp'                  => array(
//         'article:author'        => '...',
        'article:modified_time' => 'updated->format(c)|object_property',
        'article:published_time'=> 'published->format(c)|object_property',
        'article:section'       => 'category|object_property|prop_values($,name)|current($)',
        'article:tag'           => 'tag|object_property|prop_values($,name)',
        'article:publisher'     => 'code_facebook_page_id|setting->item',
        'canonical'             => 'page|object_property|base_url|implement_url_pagination',
        'description'           => ['seo_description->clean()|object_property|implement_title_pagination', 'content->chars(160)|object_property|implement_title_pagination'],
//         'fb:admins'             => '...',
        'fb:profile_id'         => '',
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => 'cover|object_property',
        'og:title'              => '@title',
        'og:type'               => 'article',
        'og:updated_time'       => '@article:modified_time',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property|implement_title_pagination', 'title->clean()|object_property|implement_title_pagination'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical',
        'ga:group'              => 'ga_group|object_property',
        'is_amp'                => 'id|object_property'
    ),
    
    'post_category'             => array(
        'canonical'             => 'page|object_property|base_url|implement_url_pagination',
        'description'           => ['seo_description->clean()|object_property|implement_title_pagination', 'description->chars(160)|object_property|implement_title_pagination'],
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => '/static/image/logo/logo.png|theme->asset',
        'og:title'              => '@title',
        'og:type'               => 'website',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property|implement_title_pagination', 'name->clean()|object_property|implement_title_pagination'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical'
    ),
    'post_tag'                  => array(
        'canonical'             => 'page|object_property|base_url|implement_url_pagination',
        'description'           => ['seo_description->clean()|object_property|implement_title_pagination', 'description->chars(160)|object_property|implement_title_pagination'],
        'keywords'              => 'seo_keywords|object_property',
        'og:description'        => '@description',
        'og:image'              => '/static/image/logo/logo.png|theme->asset',
        'og:title'              => '@title',
        'og:type'               => 'website',
        'og:url'                => '@canonical',
        'title'                 => ['seo_title->clean()|object_property|implement_title_pagination', 'name->clean()|object_property|implement_title_pagination'],
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical'
    ),
    
    'user' => array(
        'canonical'             => 'page|object_property|base_url|implement_url_pagination',
        'description'           => 'about->chars(160)|object_property|implement_title_pagination',
        'og:description'        => '@description',
        'og:image'              => 'avatar|object_property',
        'og:title'              => '@title',
        'og:type'               => 'profile',
        'og:url'                => '@canonical',
//         'profile:first_name'    => '...',
//         'profile:gender'        => '...',
//         'profile:last_name'     => '...',
        'profile:username'      => 'name|object_property',
        'title'                 => 'fullname|object_property|implement_title_pagination|hs',
        'twitter:card'          => 'summary_large_image',
        'twitter:description'   => '@description',
        'twitter:image:src'     => '@og:image',
        'twitter:title'         => '@title',
        'twitter:url'           => '@canonical'
    )
    
);