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
INSERT INTO `user` ( `name`, `fullname`, `password` ) VALUES
    ( 'root', 'System', '$2y$10$S0AE3eoOt23jHKMi.nlRHuLDE0IFqLnpOeRDT5ZMKa/.AN9zHJtSS' );

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
    ( 1, 'update-user' );