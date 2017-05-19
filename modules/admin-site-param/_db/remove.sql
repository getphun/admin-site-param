DELETE FROM `user_perms_chain` WHERE `user_perms` IN (
    SELECT `id` FROM `user_perms` WHERE `group` = 'Site Params'
);

DELETE FROM `user_perms` WHERE `group` = 'Site Params';