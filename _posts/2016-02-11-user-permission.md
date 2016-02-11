---
layout: post
title: User Permission
---

List of user permission known so far and each description of the perms.


System Enum
-----------

All permission user need to be able to do something with system enum.

1. `enum_create`  
Create new site enum value.
2. `enum_delete`  
Remove some of enum option.
3. `enum_read`  
See all enum values.
4. `enum_update`  
Update enum option value.

Front Page
----------

All permission user need about basic admin panel.

1. `admin_page_read`  
Allow user to see admin front page. This permission is required for user who need
to be able to access admin page.
2. `alexa_rank_create`  
Allow user to re-crawler alexa ranking.


Site Parameters
---------------

All permission user need to be able to do something with site parameters.

1. `site_param_create`  
Create new site parameters.
2. `site_param_delete`  
Delete site parameters.
3. `site_param_read`  
See all site parameters setting.
4. `site_param_update`  
Update site parameters value.


User Management
---------------

All permission user need to be able to do something with system user.

1. `user_create`  
Create new system user.
2. `user_delete`  
Delete some user.
3. `user_read`  
See all system user.
4. `user_update`  
Update system user setting.