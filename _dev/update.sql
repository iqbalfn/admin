INSERT INTO `perms` ( `group`, `name`, `label`, `description` ) VALUES
    ( 'Post Other', 'update-post_other_user', 'Update Other Reporter Post', 'Allow user to update other reporter posts' );

DELETE FROM `user_perms` WHERE `user` = 1;