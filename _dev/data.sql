TRUNCATE `site_params`;
INSERT INTO `site_params` ( `name`, `value` ) VALUES
    ( 'media_host', ''),
    ( 'theme_host', ''),
    ( 'site_description', 'The standart site description that will appear on meta tag of site front page' ),
    ( 'site_keywords', 'list of, site keywords, that will, appear on meta, tag of site, front page' ),
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
    ( 'post.status', 4, 'Published' );

TRUNCATE `user`;
INSERT INTO `user` ( `name`, `fullname`, `password` ) VALUES
    ( 'root', 'System', '$2y$10$S0AE3eoOt23jHKMi.nlRHuLDE0IFqLnpOeRDT5ZMKa/.AN9zHJtSS' );

TRUNCATE `user_perms`;
INSERT INTO `user_perms` ( `user`, `perms` ) VALUES
    ( 1, 'read-admin_page' ),
    
    ( 1, 'delete-gallery' ),
    ( 1, 'create-gallery' ),
    ( 1, 'read-gallery' ),
    ( 1, 'update-gallery' ),
    
    ( 1, 'delete-gallery_media' ),
    ( 1, 'create-gallery_media' ),
    ( 1, 'read-gallery_media' ),
    ( 1, 'update-gallery_media' ),
    
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
    ( 1, 'update-slide_show' );