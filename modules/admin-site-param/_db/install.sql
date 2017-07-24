INSERT IGNORE INTO `user_perms` ( `name`, `group`, `role`, `about` ) VALUES
    ( 'create_setting', 'Site Params', 'Management', 'Allow user to create new site setting' ),
    ( 'read_setting',   'Site Params', 'Management', 'Allow user to view all site settings' ),
    ( 'remove_setting', 'Site Params', 'Management', 'Allow user to remove exists site setting' ),
    ( 'update_setting', 'Site Params', 'Management', 'Allow user to update exists site setting' );