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

$route['admin/gallery']                = 'admin/gallery/object/index';
$route['admin/gallery/(:num)']         = 'admin/gallery/object/edit/$1';
$route['admin/gallery/(:num)/remove']  = 'admin/gallery/object/remove/$1';

$route['admin/gallery/(:num)/media']                = 'admin/gallery/media/index/$1';
$route['admin/gallery/(:num)/media/(:num)']         = 'admin/gallery/media/edit/$2/$1';
$route['admin/gallery/(:num)/media/(:num)/remove']  = 'admin/gallery/media/remove/$2/$1';

$route['admin/me/login']    = 'admin/me/auth/login';
$route['admin/me/logout']   = 'admin/me/auth/logout';
$route['admin/me/setting']  = 'admin/me/setting/index';

$route['admin/page']                = 'admin/page/object/index';
$route['admin/page/(:num)']         = 'admin/page/object/edit/$1';
$route['admin/page/(:num)/remove']  = 'admin/page/object/remove/$1';

$route['admin/setting/enum']                = 'admin/setting/enum/object/index';
$route['admin/setting/enum/(:num)']         = 'admin/setting/enum/object/edit/$1';
$route['admin/setting/enum/(:num)/remove']  = 'admin/setting/enum/object/remove/$1';

$route['admin/setting/menu']                = 'admin/setting/menu/object/index';
$route['admin/setting/menu/(:num)']         = 'admin/setting/menu/object/edit/$1';
$route['admin/setting/menu/(:num)/remove']  = 'admin/setting/menu/object/remove/$1';

$route['admin/setting/param']               = 'admin/setting/param/object/index';
$route['admin/setting/param/(:num)']        = 'admin/setting/param/object/edit/$1';
$route['admin/setting/param/(:num)/remove'] = 'admin/setting/param/object/remove/$1';

$route['admin/setting/slideshow']                = 'admin/setting/slideshow/object/index';
$route['admin/setting/slideshow/(:num)']         = 'admin/setting/slideshow/object/edit/$1';
$route['admin/setting/slideshow/(:num)/remove']  = 'admin/setting/slideshow/object/remove/$1';

$route['admin/user']                = 'admin/user/object/index';
$route['admin/user/(:num)']         = 'admin/user/object/edit/$1';
$route['admin/user/(:num)/remove']  = 'admin/user/object/remove/$1';

$route['upload']                            = 'media/upload';
$route['media/(:any)/(:any)/(:any)/(:any)'] = 'media/resize/$1/$2/$3/$4';

$route['default_controller']    = 'home';
$route['404_override']          = 'my_controller/show_404';
$route['translate_uri_dashes']  = FALSE;
