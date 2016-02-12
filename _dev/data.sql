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