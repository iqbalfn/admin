TRUNCATE `perms`;
INSERT INTO `perms` ( `group`, `name`, `label`, `description` ) VALUES
    ( 'Banner',          'create-banner',          'Create Banner',           'Allow user to create new banner' ),
    ( 'Banner',          'delete-banner',          'Delete Banner',           'Allow user to delete exists banner' ),
    ( 'Banner',          'read-banner',            'Read Banner',             'Allow user to see all exists banner' ),
    ( 'Banner',          'update-banner',          'Edit Banner',             'Allow user to update exists banner' ),
    ( 'Front Page',      'read-admin_page',        'Open Admin Page',         'Allow user to open admin page' ),
    ( 'Front Page',      'create-alexa_rank',      'Create Alexa Rank',       'Allow user to regenerate/create alexa rank' ),
    ( 'Front Page',      'read-google_analytics',  'Open Google Analytics',   'Allow user to see google analytics statistic' ),
    ( 'Gallery',         'create-gallery',         'Create Banner',           'Allow user to create new album gallery' ),
    ( 'Gallery',         'delete-gallery',         'Delete Banner',           'Allow user to delete exists album gallery' ),
    ( 'Gallery',         'read-gallery',           'Read Banner',             'Allow user to see all exists album gallery' ),
    ( 'Gallery',         'update-gallery',         'Edit Banner',             'Allow user to update exists album gallery' ),
    ( 'Gallery Media',   'create-gallery_media',   'Create Gallery Media',    'Allow user to create new album gallery media' ),
    ( 'Gallery Media',   'delete-gallery_media',   'Delete Gallery Media',    'Allow user to delete exists album gallery media' ),
    ( 'Gallery Media',   'read-gallery_media',     'Read Gallery Media',      'Allow user to see all exists album gallery media' ),
    ( 'Gallery Media',   'update-gallery_media',   'Edit Gallery Media',      'Allow user to update exists album gallery media' ),
    ( 'Page',            'create-page',            'Create Page',             'Allow user to create new page' ),
    ( 'Page',            'delete-page',            'Delete Page',             'Allow user to delete exists page' ),
    ( 'Page',            'read-page',              'Read Page',               'Allow user to see all exists page' ),
    ( 'Page',            'update-page',            'Edit Page',               'Allow user to update exists page' ),
    ( 'Site Enum',       'create-site_enum',       'Create Site Enum',        'Allow user to create new site enum' ),
    ( 'Site Enum',       'delete-site_enum',       'Delete Site Enum',        'Allow user to delete exists site enum' ),
    ( 'Site Enum',       'read-site_enum',         'Read Site Enum',          'Allow user to see all exists site enum' ),
    ( 'Site Enum',       'update-site_enum',       'Edit Site Enum',          'Allow user to update exists site enum' ),
    ( 'Site Menu',       'create-site_menu',       'Create Site Menu',        'Allow user to create new site menu' ),
    ( 'Site Menu',       'delete-site_menu',       'Delete Site Menu',        'Allow user to delete exists site menu' ),
    ( 'Site Menu',       'read-site_menu',         'Read Site Menu',          'Allow user to see all exists site menu' ),
    ( 'Site Menu',       'update-site_menu',       'Edit Site Menu',          'Allow user to update exists site menu' ),
    ( 'Site Parameters', 'create-site_param',      'Create Site Parameter',   'Allow user to create new site parameter' ),
    ( 'Site Parameters', 'delete-site_param',      'Delete Site Parameter',   'Allow user to delete exists site parameter' ),
    ( 'Site Parameters', 'read-site_param',        'Read Site Parameter',     'Allow user to see all exists site parameter' ),
    ( 'Site Parameters', 'update-site_param',      'Edit Site Parameter',     'Allow user to update exists site parameter' ),
    ( 'Slideshow',       'create-slide_show',      'Create Slideshow',        'Allow user to create new slideshow' ),
    ( 'Slideshow',       'delete-slide_show',      'Delete Slideshow',        'Allow user to delete exists slideshow' ),
    ( 'Slideshow',       'read-slide_show',        'Read Slideshow',          'Allow user to see all exists slideshow' ),
    ( 'Slideshow',       'update-slide_show',      'Edit Slideshow',          'Allow user to update exists slideshow' ),
    ( 'User Management', 'create-user',            'Create User',             'Allow user to create new user' ),
    ( 'User Management', 'delete-user',            'Delete User',             'Allow user to delete exists user' ),
    ( 'User Management', 'read-user',              'Read User',               'Allow user to see all exists user' ),
    ( 'User Management', 'update-user',            'Edit User',               'Allow user to update exists user' ),
    ( 'User Management', 'update-user-permission', 'Edit User Permissions',   'Allow user to update exists user permissions' );

TRUNCATE `site_params`;
INSERT INTO `site_params` ( `name`, `value` ) VALUES
    ( 'code_google_analytics', '' ),
    ( 'code_verification_alexa', '' ),
    ( 'code_verification_google', '' ),
    ( 'media_host', ''),
    ( 'theme_host', ''),
    ( 'site_frontpage_description', 'The standart site description that will appear on meta tag of site front page' ),
    ( 'site_frontpage_keywords', 'list of, site keywords, that will, appear on meta, tag of site, front page' ),
    ( 'site_frontpage_title', 'The most awesome admin system' ),
    ( 'site_name', 'Admin' ),
    ( 'site_x_social_facebook', '' ),
    ( 'site_x_social_gplus', '' ),
    ( 'site_x_social_instagram', '' ),
    ( 'site_x_social_twitter', '' ),
    ( 'site_theme', 'default' );

TRUNCATE `site_enum`;
INSERT INTO `site_enum` ( `group`, `value`, `label` ) VALUES
    ( 'post.status', 0, 'Deleted' ),
    ( 'post.status', 1, 'Draft' ),
    ( 'post.status', 2, 'Editor' ),
    ( 'post.status', 3, 'Schedule' ),
    ( 'post.status', 4, 'Published' ),
    
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
    ( 'root', 'System', '$2y$10$S0AE3eoOt23jHKMi.nlRHuLDE0IFqLnpOeRDT5ZMKa/.AN9zHJtSS', 'iqbalfawz@gmail.com' );

TRUNCATE `user_perms`;
INSERT INTO `user_perms` ( `user`, `perms` ) VALUES
    ( 1, 'read-admin_page' ),
    
    ( 1, 'delete-banner' ),
    ( 1, 'create-banner' ),
    ( 1, 'read-banner' ),
    ( 1, 'update-banner' ),
    
    ( 1, 'delete-gallery' ),
    ( 1, 'create-gallery' ),
    ( 1, 'read-gallery' ),
    ( 1, 'update-gallery' ),
    
    ( 1, 'delete-gallery_media' ),
    ( 1, 'create-gallery_media' ),
    ( 1, 'read-gallery_media' ),
    ( 1, 'update-gallery_media' ),
    
    ( 1, 'create-page' ),
    ( 1, 'delete-page' ),
    ( 1, 'read-page' ),
    ( 1, 'update-page' ),
    
    ( 1, 'create-site_param' ),
    ( 1, 'delete-site_param' ),
    ( 1, 'read-site_param' ),
    ( 1, 'update-site_param' ),
    
    ( 1, 'delete-site_menu' ),
    ( 1, 'create-site_menu' ),
    ( 1, 'read-site_menu' ),
    ( 1, 'update-site_menu' ),
    
    ( 1, 'create-site_enum' ),
    ( 1, 'delete-site_enum' ),
    ( 1, 'read-site_enum' ),
    ( 1, 'update-site_enum' ),
    
    ( 1, 'create-slide_show' ),
    ( 1, 'delete-slide_show' ),
    ( 1, 'read-slide_show' ),
    ( 1, 'update-slide_show' ),
    
    ( 1, 'create-user' ),
    ( 1, 'delete-user' ),
    ( 1, 'read-user' ),
    ( 1, 'update-user' ),
    ( 1, 'update-user-permission');