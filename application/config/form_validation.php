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
            'rules' => 'media',
            'input' => array(
                'type' => 'file',
                'file_type' => 'jpg|jpeg|png|bmp|gif|mov|mp4|mpeg|mkv'
            )
        ),
        
        'code' => array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        ),
        
        'link' => array(
            'field' => 'link',
            'label' => 'Link',
            'rules' => 'valid_url',
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
    
    '/admin/event' => array(
        
        'name' => array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[event.slug,3]',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'class' => 'slugify',
                    'data-source' => '#field-name'
                )
            )
        ),
        
        'address' => array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        ),
        
        'location' => array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => '',
            'input' => array(
                'type' => 'location'
            )
        ),
        
        'date' => array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => '',
            'input' => array(
                'type' => 'datetime'
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
        
        'cover' => array(
            'field' => 'cover',
            'label' => 'Cover',
            'rules' => 'required|media',
            'input' => array(
                'type' => 'image'
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
    
    '/admin/gallery' => array(
        
        'cover' => array(
            'field' => 'cover',
            'label' => 'Cover',
            'rules' => 'required|media',
            'input' => array(
                'type' => 'image'
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
        
        'media_label' => array(
            'field' => 'media_label',
            'label' => 'Media Label',
            'rules' => '',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'input' => array(
                'type' => 'tinymce'
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
            'rules' => 'required|valid_email|is_unique[user.email,0]',
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
    
    '/admin/post' => array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[post.slug,3]',
            'input' => array(
                'type' => 'text',
                'attrs' => array(
                    'class' => 'slugify',
                    'data-source' => '#field-title'
                )
            )
        ),
        
        'embed' => array(
            'field' => 'embed',
            'label' => 'Embed Script',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
            )
        ),
        
        'category' => array(
            'field' => 'category',
            'label' => 'Category',
            'rules' => '',
            'input' => array(
                'type' => 'multiple'
            )
        ),
        
        'tag' => array(
            'field' => 'tag',
            'label' => 'Tag',
            'rules' => '',
            'input' => array(
                'type' => 'object-multiple',
                'attrs' => array(
                    'data-table' => 'post_tag',
                    'data-label' => 'name',
                    'data-value' => 'id'
                )
            )
        ),
        
        'gallery' => array(
            'field' => 'gallery',
            'label' => 'Gallery',
            'rules' => 'in_table[gallery.id]',
            'input' => array(
                'type' => 'object',
                'attrs' => array(
                    'data-table' => 'gallery',
                    'data-label' => 'name',
                    'data-value' => 'id'
                )
            )
        ),
        
        'location' => array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => '',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => '',
            'input' => array(
                'type' => 'select'
            )
        ),
        
        'published' => array(
            'field' => 'published',
            'label' => 'Published Schedule',
            'rules' => '',
            'input' => array(
                'type' => 'datetime'
            )
        ),
        
        'sources' => array(
            'field' => 'sources',
            'label' => 'Source',
            'rules' => 'valid_url',
            'input' => array(
                'type' => 'url'
            )
        ),
        
        'featured' => array(
            'field' => 'featured',
            'label' => 'Featured',
            'rules' => '',
            'input' => array(
                'type' => 'boolean'
            )
        ),
        
        'editor_pick' => array(
            'field' => 'editor_pick',
            'label' => 'Editor Pick',
            'rules' => '',
            'input' => array(
                'type' => 'boolean'
            )
        ),
        
        'cover' => array(
            'field' => 'cover',
            'label' => 'Cover',
            'rules' => 'required|media',
            'input' => array(
                'type' => 'image'
            )
        ),
        
        'cover_label' => array(
            'field' => 'cover_label',
            'label' => 'Cover Label',
            'rules' => '',
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
        ),
        
        'ga_group' => array(
            'field' => 'ga_group',
            'label' => 'GAnalytics Group',
            'rules' => '',
            'input' => array(
                'type' => 'text'
            )
        )
    ),
    
    '/admin/post/selector' => array(
        'post' => array(
            'field' => 'post',
            'label' => 'Post',
            'rules' => 'required|in_table[post.id]',
            'input' => array(
                'type' => 'object',
                'attrs' => array(
                    'data-table' => 'post',
                    'data-label' => 'title',
                    'data-value' => 'id'
                )
            )
        ),
        
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
        
        'index' => array(
            'field' => 'index',
            'label' => 'Index',
            'rules' => 'is_natural_no_zero',
            'input' => array(
                'type' => 'number'
            )
        )
    ),
    
    '/admin/post/suggestion' => array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'source' => array(
            'field' => 'source',
            'label' => 'Source',
            'rules' => 'required|valid_url',
            'input' => array(
                'type' => 'url'
            )
        ),
        
        'local' => array(
            'field' => 'local',
            'label' => 'Local',
            'rules' => 'valid_url',
            'input' => array(
                'type' => 'url'
            )
        )
    ),
    
    '/admin/post/tag' => array(
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[post_tag.slug,4]',
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
    
    '/admin/post/category' => array(
        'slug' => array(
            'field' => 'slug',
            'label' => 'Slug',
            'rules' => 'required|is_unique[post_category.slug,4]',
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
        
        'parent' => array(
            'field' => 'parent',
            'label' => 'Parent',
            'rules' => 'required',
            'input' => array(
                'type' => 'parent'
            )
        ),
        
        'description' => array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'input' => array(
                'type' => 'textarea'
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
    
    '/admin/setting/redirection' => array(
    
        'source' => array(
            'field' => 'source',
            'label' => 'URL Source',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
            )
        ),
        
        'target' => array(
            'field' => 'target',
            'label' => 'Redirect To',
            'rules' => 'required',
            'input' => array(
                'type' => 'text'
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
            'rules' => 'required|valid_email|is_unique[user.email,3]',
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
            'rules' => 'required',
            'input' => array(
                'type' => 'select'
            )
        )
    )
    
);