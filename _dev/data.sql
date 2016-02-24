TRUNCATE `site_params`;
INSERT INTO `site_params` ( `name`, `value` ) VALUES
    ( 'site_description', 'The standart site description that will appear on meta tag of site front page' ),
    ( 'site_keywords', 'list of, site keywords, that will, appear on meta, tag of site, front page' ),
    ( 'site_name', 'Admin' ),
    ( 'site_x_social_facebook', '' ),
    ( 'site_x_social_gplus', '' ),
    ( 'site_x_social_instagram', '' ),
    ( 'site_x_social_twitter', '' ),
    ( 'site_theme', 'default' );

TRUNCATE `enum`;
INSERT INTO `enum` ( `group`, `value`, `label` ) VALUES
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
    ( 1, 'read_admin-page' ),
    
    ( 1, 'create_system-enum' ),
    ( 1, 'delete_system-enum' ),
    ( 1, 'read_system-enum' ),
    ( 1, 'update_system-enum' ),
    
    ( 1, 'create_site-param' ),
    ( 1, 'delete_site-param' ),
    ( 1, 'read_site-param' ),
    ( 1, 'update_site-param' );