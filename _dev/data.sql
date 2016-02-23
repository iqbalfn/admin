TRUNCATE `site_params`;
INSERT INTO `site_params` ( `name`, `value` ) VALUES
    ( 'site_name', 'Admin' ),
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
    ( 1, 'update_system-enum' );