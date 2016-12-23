<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['admin'] = 'admin/home/object/index';

$route['admin/banner']                = 'admin/banner/object/index';
$route['admin/banner/(:num)']         = 'admin/banner/object/edit/$1';
$route['admin/banner/(:num)/remove']  = 'admin/banner/object/remove/$1';

$route['admin/event']                = 'admin/event/object/index';
$route['admin/event/(:num)']         = 'admin/event/object/edit/$1';
$route['admin/event/(:num)/remove']  = 'admin/event/object/remove/$1';

$route['admin/gallery']                 = 'admin/gallery/object/index';
$route['admin/gallery/(:num)']          = 'admin/gallery/object/edit/$1';
$route['admin/gallery/(:num)/remove']   = 'admin/gallery/object/remove/$1';
$route['admin/gallery/(:num)/download'] = 'admin/gallery/object/download/$1';

$route['admin/gallery/(:num)/media']                = 'admin/gallery/media/index/$1';
$route['admin/gallery/(:num)/media/(:num)']         = 'admin/gallery/media/edit/$2/$1';
$route['admin/gallery/(:num)/media/(:num)/remove']  = 'admin/gallery/media/remove/$2/$1';

$route['admin/me/login']    = 'admin/me/auth/login';
$route['admin/me/logout']   = 'admin/me/auth/logout';
$route['admin/me/relogin']  = 'admin/me/auth/relogin';
$route['admin/me/setting']  = 'admin/me/setting/index';

$route['admin/object-filter'] = 'admin/object-filter/object/index';

$route['admin/page']                = 'admin/page/object/index';
$route['admin/page/(:num)']         = 'admin/page/object/edit/$1';
$route['admin/page/(:num)/remove']  = 'admin/page/object/remove/$1';

$route['admin/post']                = 'admin/post/object/index';
$route['admin/post/(:num)']         = 'admin/post/object/edit/$1';
$route['admin/post/(:num)/remove']  = 'admin/post/object/remove/$1';

$route['admin/post/category']                = 'admin/post/category/index';
$route['admin/post/category/(:num)']         = 'admin/post/category/edit/$1';
$route['admin/post/category/(:num)/remove']  = 'admin/post/category/remove/$1';

$route['admin/post/publish'] = 'admin/post/publish/index';

$route['admin/post/instant/clear'] = 'admin/post/instant/clear';

$route['admin/post/selector']                = 'admin/post/selector/index';
$route['admin/post/selector/(:num)']         = 'admin/post/selector/edit/$1';
$route['admin/post/selector/(:num)/remove']  = 'admin/post/selector/remove/$1';

$route['admin/post/suggestion']                = 'admin/post/suggestion/index';
$route['admin/post/suggestion/(:num)']         = 'admin/post/suggestion/edit/$1';
$route['admin/post/suggestion/(:num)/remove']  = 'admin/post/suggestion/remove/$1';

$route['admin/post/tag']                = 'admin/post/tag/index';
$route['admin/post/tag/(:num)']         = 'admin/post/tag/edit/$1';
$route['admin/post/tag/(:num)/remove']  = 'admin/post/tag/remove/$1';

$route['admin/post/trending'] = 'admin/post/trending/index';
$route['admin/post/statistic'] = 'admin/post/statistic/index';

$route['admin/setting/enum']                = 'admin/setting/enum/object/index';
$route['admin/setting/enum/(:num)']         = 'admin/setting/enum/object/edit/$1';
$route['admin/setting/enum/(:num)/remove']  = 'admin/setting/enum/object/remove/$1';

$route['admin/setting/menu']                = 'admin/setting/menu/object/index';
$route['admin/setting/menu/(:num)']         = 'admin/setting/menu/object/edit/$1';
$route['admin/setting/menu/(:num)/remove']  = 'admin/setting/menu/object/remove/$1';

$route['admin/setting/param']               = 'admin/setting/param/object/index';
$route['admin/setting/param/(:num)']        = 'admin/setting/param/object/edit/$1';
$route['admin/setting/param/(:num)/remove'] = 'admin/setting/param/object/remove/$1';

$route['admin/setting/redirection']                = 'admin/setting/redirection/object/index';
$route['admin/setting/redirection/(:num)']         = 'admin/setting/redirection/object/edit/$1';
$route['admin/setting/redirection/(:num)/remove']  = 'admin/setting/redirection/object/remove/$1';

$route['admin/setting/slideshow']                = 'admin/setting/slideshow/object/index';
$route['admin/setting/slideshow/(:num)']         = 'admin/setting/slideshow/object/edit/$1';
$route['admin/setting/slideshow/(:num)/remove']  = 'admin/setting/slideshow/object/remove/$1';

$route['admin/setting/cache/clear'] = 'admin/setting/cache/object/clear';

$route['admin/setting/media/clear']   = 'admin/setting/media/object/clear';
$route['admin/setting/media/execute'] = 'admin/setting/media/object/execute';

$route['admin/stat/ranks']            = 'admin/stat/object/ranks';
$route['admin/stat/realtime']         = 'admin/stat/object/realtime';
$route['admin/stat/visitor']          = 'admin/stat/object/visitor';
$route['admin/stat/calculate/(:any)'] = 'admin/stat/object/calculate/$1';

$route['admin/user']                = 'admin/user/object/index';
$route['admin/user/(:num)']         = 'admin/user/object/edit/$1';
$route['admin/user/(:num)/remove']  = 'admin/user/object/remove/$1';

$route['upload']                            = 'media/upload';
$route['media/(:any)/(:any)/(:any)/(:any)'] = 'media/resize/$1/$2/$3/$4';

$route['event/feed.xml'] = 'event/feed';
$route['event/(:any)'] = 'event/single/$1';

$route['page/(:any)'] = 'page/single/$1';

$route['post/feed.xml'] = 'post/feed';
$route['post/instant.xml'] = 'post/feed/instant';

$route['post/read/(:any)'] = 'post/single/$1';
$route['post/amp/(:any)'] = 'post/amp/$1';

$route['post/category/(:any)/feed.xml'] = 'post/categoryFeed/$1';
$route['post/category/(:any)'] = 'post/category/$1';

$route['post/tag/(:any)/feed.xml'] = 'post/tagFeed/$1';
$route['post/tag/(:any)'] = 'post/tag/$1';

$route['user/(:any)'] = 'user/single/$1';
$route['user/(:any)/post/feed.xml'] = 'user/feedPost/$1';

$route['feed.xml'] = 'robot/feed';
$route['sitemap.xml'] = 'robot/sitemap';
$route['sitemap-news.xml'] = 'robot/sitemapNews';

$route['default_controller']    = 'home';
$route['404_override']          = 'my_controller/show_404';
$route['translate_uri_dashes']  = FALSE;
