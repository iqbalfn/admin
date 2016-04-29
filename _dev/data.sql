TRUNCATE `perms`;
INSERT INTO `perms` ( `group`, `name`, `label`, `description` ) VALUES
    ( 'Banner',             'create-banner',            'Create Banner',                'Allow user to create new banner' ),
    ( 'Banner',             'delete-banner',            'Delete Banner',                'Allow user to delete exists banner' ),
    ( 'Banner',             'read-banner',              'Read Banner',                  'Allow user to see all exists banner' ),
    ( 'Banner',             'update-banner',            'Edit Banner',                  'Allow user to update exists banner' ),
    ( 'Event',              'create-event',             'Create Event',                 'Allow user to create new event' ),
    ( 'Event',              'delete-event',             'Delete Event',                 'Allow user to delete exists event' ),
    ( 'Event',              'read-event',               'Read Event',                   'Allow user to see all exists event' ),
    ( 'Event',              'update-event',             'Edit Event',                   'Allow user to update exists event' ),
    ( 'Front Page',         'read-admin_page',          'Open Admin Page',              'Allow user to open admin page' ),
    ( 'Gallery',            'create-gallery',           'Create Banner',                'Allow user to create new album gallery' ),
    ( 'Gallery',            'delete-gallery',           'Delete Banner',                'Allow user to delete exists album gallery' ),
    ( 'Gallery',            'read-gallery',             'Read Banner',                  'Allow user to see all exists album gallery' ),
    ( 'Gallery',            'update-gallery',           'Edit Banner',                  'Allow user to update exists album gallery' ),
    ( 'Gallery Media',      'create-gallery_media',     'Create Gallery Media',         'Allow user to create new album gallery media' ),
    ( 'Gallery Media',      'delete-gallery_media',     'Delete Gallery Media',         'Allow user to delete exists album gallery media' ),
    ( 'Gallery Media',      'read-gallery_media',       'Read Gallery Media',           'Allow user to see all exists album gallery media' ),
    ( 'Gallery Media',      'update-gallery_media',     'Edit Gallery Media',           'Allow user to update exists album gallery media' ),
    ( 'Page',               'create-page',              'Create Page',                  'Allow user to create new page' ),
    ( 'Page',               'delete-page',              'Delete Page',                  'Allow user to delete exists page' ),
    ( 'Page',               'read-page',                'Read Page',                    'Allow user to see all exists page' ),
    ( 'Page',               'update-page',              'Edit Page',                    'Allow user to update exists page' ),
    ( 'Post',               'create-post',              'Create Post',                  'Allow user to create new post' ),
    ( 'Post',               'delete-post',              'Delete Post',                  'Allow user to delete exists post' ),
    ( 'Post',               'read-post',                'Read Post',                    'Allow user to see all exists post' ),
    ( 'Post',               'update-post',              'Edit Post',                    'Allow user to update exists post' ),
    ( 'Post Other',         'create-post_featured',     'Set Post As Featured',         'Allow user to set post as featured' ),
    ( 'Post Other',         'create-post_editor_pick',  'Set Post As Editor Pick',      'Allow user to set post as editor pick' ),
    ( 'Post Other',         'delete-post_other_user',   'Delete Other Reporter Post',   'Allow user to remove other reporter posts' ),
    ( 'Post Other',         'read-post_other_user',     'Read Other Reporter Post',     'Allow user to see other reporter posts' ),
    ( 'Post Other',         'create-post_published',    'Publish Post',                 'Allow user to publish the post' ),
    ( 'Post Other',         'update-post_slug',         'Edit Post Slug',               'Allow user to update the post slug' ),
    ( 'Post Cateogry',      'create-post_category',     'Create Post Category',         'Allow user to create new post category' ),
    ( 'Post Cateogry',      'delete-post_category',     'Delete Post Category',         'Allow user to delete exists post category' ),
    ( 'Post Cateogry',      'read-post_category',       'Read Post Category',           'Allow user to see all exists post category' ),
    ( 'Post Cateogry',      'update-post_category',     'Edit Post Category',           'Allow user to update exists post category' ),
    ( 'Post Tag',           'create-post_tag',          'Create Post Tag',              'Allow user to create new post category' ),
    ( 'Post Tag',           'delete-post_tag',          'Delete Post Tag',              'Allow user to delete exists post category' ),
    ( 'Post Tag',           'read-post_tag',            'Read Post Tag',                'Allow user to see all exists post category' ),
    ( 'Post Tag',           'update-post_tag',          'Edit Post Tag',                'Allow user to update exists post category' ),
    ( 'Post Selector',      'create-post_selector',     'Create Post Selection',        'Allow user to create new post selection' ),
    ( 'Post Selector',      'delete-post_selector',     'Delete Post Selection',        'Allow user to delete exists post selection' ),
    ( 'Post Selector',      'read-post_selector',       'Read Post Selection',          'Allow user to see all exists post selection' ),
    ( 'Post Selector',      'update-post_selector',     'Edit Post Selection',          'Allow user to update exists post selection' ),
    ( 'Post Suggestion',    'create-post_suggestion',   'Create Post Suggestion',       'Allow user to create new post suggestion' ),
    ( 'Post Suggestion',    'delete-post_suggestion',   'Delete Post Suggestion',       'Allow user to delete exists post suggestion' ),
    ( 'Post Suggestion',    'read-post_suggestion',     'Read Post Suggestion',         'Allow user to see all exists post suggestion' ),
    ( 'Post Suggestion',    'update-post_suggestion',   'Edit Post Suggestion',         'Allow user to update exists post suggestion' ),
    ( 'Site Enum',          'create-site_enum',         'Create Site Enum',             'Allow user to create new site enum' ),
    ( 'Site Enum',          'delete-site_enum',         'Delete Site Enum',             'Allow user to delete exists site enum' ),
    ( 'Site Enum',          'read-site_enum',           'Read Site Enum',               'Allow user to see all exists site enum' ),
    ( 'Site Enum',          'update-site_enum',         'Edit Site Enum',               'Allow user to update exists site enum' ),
    ( 'Site Menu',          'create-site_menu',         'Create Site Menu',             'Allow user to create new site menu' ),
    ( 'Site Menu',          'delete-site_menu',         'Delete Site Menu',             'Allow user to delete exists site menu' ),
    ( 'Site Menu',          'read-site_menu',           'Read Site Menu',               'Allow user to see all exists site menu' ),
    ( 'Site Menu',          'update-site_menu',         'Edit Site Menu',               'Allow user to update exists site menu' ),
    ( 'Site Parameters',    'create-site_param',        'Create Site Parameter',        'Allow user to create new site parameter' ),
    ( 'Site Parameters',    'delete-site_param',        'Delete Site Parameter',        'Allow user to delete exists site parameter' ),
    ( 'Site Parameters',    'read-site_param',          'Read Site Parameter',          'Allow user to see all exists site parameter' ),
    ( 'Site Parameters',    'update-site_param',        'Edit Site Parameter',          'Allow user to update exists site parameter' ),
    ( 'Site Statistic',     'read-site_ranks',          'Read Site Ranks',              'Allow user to see all site ranks' ),
    ( 'Site Statistic',     'read-site_realtime',       'Read Realtime Statistic',      'Allow user to see all site realtime statistic' ),
    ( 'Site Statistic',     'read-visitor_statistic',   'Read Visitor Statistic',       'Allow user to see all site visitor statistic' ),
    ( 'Site Cache',         'delete-cache',             'Remove All Site Cache',        'Allow user to remove all site cache' ),
    ( 'Site Media',         'delete-media_sizes',       'Remove All Media Resizes',     'Allow user to remove all resized media' ),
    ( 'Slideshow',          'create-slide_show',        'Create Slideshow',             'Allow user to create new slideshow' ),
    ( 'Slideshow',          'delete-slide_show',        'Delete Slideshow',             'Allow user to delete exists slideshow' ),
    ( 'Slideshow',          'read-slide_show',          'Read Slideshow',               'Allow user to see all exists slideshow' ),
    ( 'Slideshow',          'update-slide_show',        'Edit Slideshow',               'Allow user to update exists slideshow' ),
    ( 'URL Redirection',    'create-url_redirection',   'Create URL Redirection',       'Allow user to create new url redirection' ),
    ( 'URL Redirection',    'delete-url_redirection',   'Delete URL Redirection',       'Allow user to delete exists url redirection' ),
    ( 'URL Redirection',    'read-url_redirection',     'Read URL Redirection',         'Allow user to see all exists url redirection' ),
    ( 'URL Redirection',    'update-url_redirection',   'Edit URL Redirection',         'Allow user to update exists url redirection' ),
    ( 'User Management',    'create-user',              'Create User',                  'Allow user to create new user' ),
    ( 'User Management',    'delete-user',              'Delete User',                  'Allow user to delete exists user' ),
    ( 'User Management',    'read-user',                'Read User',                    'Allow user to see all exists user' ),
    ( 'User Management',    'update-user',              'Edit User',                    'Allow user to update exists user' ),
    ( 'User Management',    'update-user_password',     'Edit User Password',           'Allow user to update exists user password' ),
    ( 'User Management',    'update-user_permission',   'Edit User Permissions',        'Allow user to update exists user permissions' ),
    ( 'User Management',    'update-user_session',      'Login As Other User',          'Allow user to login as other user' );

TRUNCATE `site_params`;
INSERT INTO `site_params` ( `name`, `value` ) VALUES
    ( 'code_application_facebook', '' ),
    ( 'code_google_analytics', '' ),
    ( 'code_google_analytics_view', '' ),
    ( 'google_analytics_content_group', '1' ),
    ( 'code_google_map', '' ),
    ( 'code_verification_alexa', '' ),
    ( 'code_verification_bing', '' ),
    ( 'code_verification_pinterest', '' ),
    ( 'code_verification_google', '' ),
    ( 'code_verification_yandex', '' ),
    ( 'code_facebook_page_id', '' ),
    
    ( 'google_analytics_statistic', 'google-analytics.json' ),
    
    ( 'media_host', ''),
    
    ( 'organization_email', '' ),
    ( 'organization_contact_customer_support', '' ),
    ( 'organization_contact_technical_support', '' ),
    ( 'organization_contact_billing_support', '' ),
    ( 'organization_contact_bill_payment', '' ),
    ( 'organization_contact_sales', '' ),
    ( 'organization_contact_reservations', '' ),
    ( 'organization_contact_credit_card_support', '' ),
    ( 'organization_contact_emergency', '' ),
    ( 'organization_contact_baggage_tracking', '' ),
    ( 'organization_contact_roadside_assistance', '' ),
    ( 'organization_contact_package_tracking', '' ),
    
    ( 'organization_contact_available_language', '' ),
    ( 'organization_contact_area_served', '' ),
    ( 'organization_contact_opt_tollfree', '' ),
    ( 'organization_contact_opt_his', '' ),
    
    ( 'site_frontpage_description', 'The standart site description that will appear on meta tag of site front page' ),
    ( 'site_frontpage_keywords', 'list of, site keywords, that will, appear on meta, tag of site, front page' ),
    ( 'site_frontpage_title', 'The most awesome admin system' ),
    ( 'site_name', 'Admin' ),
    
    ( 'site_x_social_facebook', '' ),
    ( 'site_x_social_gplus', '' ),
    ( 'site_x_social_instagram', '' ),
    ( 'site_x_social_linkedin', '' ),
    ( 'site_x_social_myspace', '' ),
    ( 'site_x_social_pinterest', '' ),
    ( 'site_x_social_soundcloud', '' ),
    ( 'site_x_social_tumblr', '' ),
    ( 'site_x_social_twitter', '' ),
    ( 'site_x_social_youtube', '' ),
    
    ( 'site_theme', 'default' ),
    ( 'site_theme_responsive', '1' ),
    
    ( 'sitemap_news', '1'),
    
    ( 'theme_host', ''),
    ( 'theme_include_fb_js_api', '1'),
    ( 'theme_include_fb_js_api_with_ads', '0' ),
    
    ( 'amphtml_support_for_post', '1'),
    ( 'instant_article_support_for_post', '0' );

TRUNCATE `site_enum`;
INSERT INTO `site_enum` ( `group`, `value`, `label` ) VALUES
    ( 'event.seo_schema', 'Event', 'Event' ),
    
    ( 'gallery.seo_schema', 'CollectionPage', 'CollectionPage' ),
    ( 'gallery.seo_schema', 'ImageGallery', 'ImageGallery' ),
    ( 'gallery.seo_schema', 'VideoGallery', 'VideoGallery' ),
    
    ( 'gallery_media.seo_schema', 'MediaObject', 'MediaObject' ),
    ( 'gallery_media.seo_schema', 'AudioObject', 'AudioObject' ),
    ( 'gallery_media.seo_schema', 'ImageObject', 'ImageObject' ),
    ( 'gallery_media.seo_schema', 'MusicVideoObject', 'MusicVideoObject' ),
    ( 'gallery_media.seo_schema', 'VideoObject', 'VideoObject' ),
    
    ( 'post.status', 1, 'Draft' ),
    ( 'post.status', 2, 'Editor' ),
    ( 'post.status', 3, 'Schedule' ),
    ( 'post.status', 4, 'Published' ),
    
    ( 'post.seo_schema', 'CreativeWork', 'CreativeWork' ),
    ( 'post.seo_schema', 'Article', 'Article' ),
    ( 'post.seo_schema', 'NewsArticle', 'NewsArticle' ),
    ( 'post.seo_schema', 'BlogPosting', 'BlogPosting' ),
    ( 'post.seo_schema', 'TechArticle', 'TechArticle' ),
    ( 'post.seo_schema', 'Report', 'Report' ),
    ( 'post.seo_schema', 'Review', 'Review' ),
    
    ( 'post_category.seo_schema', 'CollectionPage', 'CollectionPage' ),
    ( 'post_tag.seo_schema', 'CollectionPage', 'CollectionPage' ),
    
    ( 'page.seo_schema', 'WebPage', 'WebPage' ),
    ( 'page.seo_schema', 'AboutPage', 'AboutPage' ),
    ( 'page.seo_schema', 'CheckoutPage', 'CheckoutPage' ),
    ( 'page.seo_schema', 'ContactPage ', 'ContactPage ' ),
    ( 'page.seo_schema', 'QAPage', 'QAPage' ),
    ( 'page.seo_schema', 'SearchResultsPage', 'SearchResultsPage' ),
    
    ( 'user.status', 0, 'Deleted' ),
    ( 'user.status', 1, 'Banned' ),
    ( 'user.status', 2, 'Unverified' ),
    ( 'user.status', 3, 'Verified' ),
    ( 'user.status', 4, 'Official' );

TRUNCATE `user`;
INSERT INTO `user` ( `name`, `fullname`, `password`, `email` ) VALUES
    ( 'root', 'System', '$2y$10$Fyny0EXBwGlzPYrr/wSOL.ScgC0B6Irgyttuc/w9kkMwaAd2Vk/l6', 'root@system.admin' );

TRUNCATE `user_perms`;
INSERT INTO `user_perms` ( `user`, `perms` ) VALUES
    -- FRONT PAGE
    ( 1, 'read-admin_page' ),
    
    -- BANNER
    ( 1, 'delete-banner' ),
    ( 1, 'create-banner' ),
    ( 1, 'read-banner' ),
    ( 1, 'update-banner' ),
    
    -- EVENT
    ( 1, 'delete-event' ),
    ( 1, 'create-event' ),
    ( 1, 'read-event' ),
    ( 1, 'update-event' ),
    
    -- GALLERY
    ( 1, 'delete-gallery' ),
    ( 1, 'create-gallery' ),
    ( 1, 'read-gallery' ),
    ( 1, 'update-gallery' ),
    
    -- GALLERY MEDIA
    ( 1, 'delete-gallery_media' ),
    ( 1, 'create-gallery_media' ),
    ( 1, 'read-gallery_media' ),
    ( 1, 'update-gallery_media' ),
    
    -- PAGE/STATIC PAGE
    ( 1, 'create-page' ),
    ( 1, 'delete-page' ),
    ( 1, 'read-page' ),
    ( 1, 'update-page' ),
    
    -- POST
    ( 1, 'create-post' ),
    ( 1, 'delete-post' ),
    ( 1, 'read-post' ),
    ( 1, 'update-post' ),
    
    ( 1, 'create-post_featured' ),
    ( 1, 'create-post_editor_pick' ),
    ( 1, 'create-post_published' ),
    ( 1, 'delete-post_other_user' ),
    ( 1, 'read-post_other_user' ),
    ( 1, 'update-post_slug' ),
    
    -- POST CATEGORY
    ( 1, 'create-post_category' ),
    ( 1, 'delete-post_category' ),
    ( 1, 'read-post_category' ),
    ( 1, 'update-post_category' ),
    
    -- POST TAG
    ( 1, 'create-post_tag' ),
    ( 1, 'delete-post_tag' ),
    ( 1, 'read-post_tag' ),
    ( 1, 'update-post_tag' ),
    
    -- POST SELECTION
    ( 1, 'create-post_selector' ),
    ( 1, 'delete-post_selector' ),
    ( 1, 'read-post_selector' ),
    ( 1, 'update-post_selector' ),
    
    -- POST SUGGESTION
    ( 1, 'create-post_suggestion' ),
    ( 1, 'delete-post_suggestion' ),
    ( 1, 'read-post_suggestion' ),
    ( 1, 'update-post_suggestion' ),
    
    -- SITE PARAMS
    ( 1, 'create-site_param' ),
    ( 1, 'delete-site_param' ),
    ( 1, 'read-site_param' ),
    ( 1, 'update-site_param' ),
    
    -- SITE MENU
    ( 1, 'delete-site_menu' ),
    ( 1, 'create-site_menu' ),
    ( 1, 'read-site_menu' ),
    ( 1, 'update-site_menu' ),
    
    -- SITE ENUM
    ( 1, 'create-site_enum' ),
    ( 1, 'delete-site_enum' ),
    ( 1, 'read-site_enum' ),
    ( 1, 'update-site_enum' ),
    
    -- SITE MEDIA
    ( 1, 'delete-media_sizes' ),
    
    -- SLIDE SHOW
    ( 1, 'create-slide_show' ),
    ( 1, 'delete-slide_show' ),
    ( 1, 'read-slide_show' ),
    ( 1, 'update-slide_show' ),
    
    -- SITE STATISTIC
    ( 1, 'read-site_ranks' ),
    ( 1, 'read-site_realtime' ),
    ( 1, 'read-visitor_statistic' ),
    
    -- SITE CACHE
    ( 1, 'delete-cache' ),
    
    -- URL REDIRECTION
    ( 1, 'create-url_redirection' ),
    ( 1, 'delete-url_redirection' ),
    ( 1, 'read-url_redirection' ),
    ( 1, 'update-url_redirection' ),
    
    -- USER
    ( 1, 'create-user' ),
    ( 1, 'delete-user' ),
    ( 1, 'read-user' ),
    ( 1, 'update-user' ),
    ( 1, 'update-user_password' ),
    ( 1, 'update-user_permission'),
    ( 1, 'update-user_session' );