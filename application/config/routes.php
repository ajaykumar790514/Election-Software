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
$route['default_controller']   = 'dashboard';
$route['404_override'] 			 = 'pagenotfound';
$route['translate_uri_dashes'] = FALSE;

$route['test/(:any)']			= 'main/test/$1';
$route['admin-login']			= 'login/index/admin';
$route['admin-mobile-otp']			= 'login/admin_mobile_otp';
$route['admin-check-otp']			= 'login/admin_check_otp';
$route['admin-update-pass']			= 'login/admin_update_pass';
$route['delete_otp'] = 'login/delete_otp';

$route['member-login']			= 'login/index/member';
$route['member-logout']			= 'login/logout';
$route['member-mobile-otp']			= 'login/member_mobile_otp';
$route['member-check-otp']			= 'login/member_check_otp';
$route['member-update-pass']			= 'login/member_update_pass';

$route['dashboard_content'] 	 = 'dashboard/dashboard_content';
$route['host_dashboard_content'] = 'dashboard/host_dashboard_content';

$route['changeStatusDispaly']  = 'main/changeStatusDispaly';
$route['change_status']        = 'main/change_status';
$route['change_status2']        = 'main/change_status2';
$route['changeIndexing']       = 'main/changeIndexing';
$route['title/(:any)/(:num)']  = 'main/title/$1/$2';
$route['logout'] 	           = 'login/logout';



// Start:: Profile
$route['profile']		        	= 'profile/index';
$route['profile/(:any)']			= 'profile/index/$1';
$route['member-profile/(:any)']			= 'profile/member_profile/$1';
$route['change-password']		        	= 'profile/member_profile/change_password';

// End:: Profile

// Start Remote
$route['remote/(:any)'] 		= 'masters/remote/$1';
$route['remote/(:any)/(:any)'] 	= 'masters/remote/$1/$2';
$route['remote/(:any)/(:any)/(:any)'] = 'masters/remote/$1/$2/$3';
// End Remote

$route['admin-menu'] 		= 'users/admin_menu/';
$route['admin-menu/(:any)'] 	= 'users/admin_menu/$1';
$route['admin-menu/(:any)/(:any)'] = 'users/admin_menu/$1/$2';


$route['users'] 		= 'users/user/';
$route['users/(:any)'] 	= 'users/user/$1';
$route['users/(:any)/(:any)'] = 'users/user/$1/$2';
$route['users/(:any)/(:any)/(:any)'] = 'users/user/$1/$2/$3';

$route['user-role'] 		= 'users/user_role/';
$route['user-role/(:any)'] 	= 'users/user_role/$1';
$route['user-role/(:any)/(:any)'] = 'users/user_role/$1/$2';

$route['master-data'] 		= 'master/';
$route['master-data/(:any)'] 	= 'master/$1';
$route['master-data/(:any)/(:any)'] = 'master/$1/$2';
$route['master-data/(:any)/(:any)/(:any)'] = 'master/$1/$2/$3';
$route['master-data/(:any)/(:any)/(:any)/(:any)'] = 'master/$1/$2/$3/$4';

$route['countries'] 		= 'master/countries/';
$route['countries/(:any)'] 	= 'master/countries/$1';
$route['countries/(:any)/(:any)'] = 'master/countries/$1/$2';

$route['states'] 		= 'master/states/';
$route['states/(:any)'] 	= 'master/states/$1';
$route['states/(:any)/(:any)'] = 'master/states/$1/$2';

$route['commissionaires'] 		= 'master/commissionaires/';
$route['commissionaires/(:any)'] 	= 'master/commissionaires/$1';
$route['commissionaires/(:any)/(:any)'] = 'master/commissionaires/$1/$2';

$route['district'] 		= 'master/district/';
$route['district/(:any)'] 	= 'master/district/$1';
$route['district/(:any)/(:any)'] = 'master/district/$1/$2';

$route['tehsil-zone'] 		= 'master/tehsil_zone/';
$route['tehsil-zone/(:any)'] 	= 'master/tehsil_zone/$1';
$route['tehsil-zone/(:any)/(:any)'] = 'master/tehsil_zone/$1/$2';

$route['ward-block'] 		= 'master/ward_block/';
$route['ward-block/(:any)'] 	= 'master/ward_block/$1';
$route['ward-block/(:any)/(:any)'] = 'master/ward_block/$1/$2';

$route['block-nyay'] 		= 'master/block_nyay/';
$route['block-nyay/(:any)'] 	= 'master/block_nyay/$1';
$route['block-nyay/(:any)/(:any)'] = 'master/block_nyay/$1/$2';

$route['panchayat'] 		= 'master/panchayat/';
$route['panchayat/(:any)'] 	= 'master/panchayat/$1';
$route['panchayat/(:any)/(:any)'] = 'master/panchayat/$1/$2';

$route['enrollment/(:any)'] 	= 'enrollment/$1';
$route['enrollment/(:any)/(:any)'] = 'enrollment/$1/$2';
$route['enrollment/(:any)/(:any)/(:any)'] = 'enrollment/$1/$2/$3';



$route['members-enrollment'] 		= 'enrollment/enrollment/';
$route['members-enrollment/(:any)'] 	= 'enrollment/enrollment/$1';
$route['members-enrollment/(:any)/(:any)'] = 'enrollment/enrollment/$1/$2';

$route['level-master'] 		= 'master/level_master/';
$route['level-master/(:any)'] 	= 'master/level_master/$1';
$route['level-master/(:any)/(:num)'] = 'master/level_master/$1/$2';

$route['operations/(:any)'] 	= 'operations/$1';
$route['operations/(:any)/(:any)'] = 'operations/$1/$2';
$route['operations/(:any)/(:any)/(:any)'] = 'operations/$1/$2/$3';


$route['family-blocks'] 		= 'operations/family_blocks/';
$route['family-blocks/(:any)'] 	= 'operations/family_blocks/$1';
$route['family-blocks/(:any)/(:any)'] = 'operations/family_blocks/$1/$2';


$route['members-level'] 		= 'operations/members_level/';
$route['members-level/(:any)'] 	= 'operations/members_level/$1';
$route['members-level/(:any)/(:any)'] = 'operations/members_level/$1/$2';

$route['winner-candidates'] 		= 'operations/winner_candidates/';
$route['winner-candidates/(:any)'] 	= 'operations/winner_candidates/$1';
$route['winner-candidates/(:any)/(:any)'] = 'operations/winner_candidates/$1/$2';


$route['family-details/(:any)'] 		= 'operations/family_details/$1';
$route['family-details/(:any)/(:any)'] 	= 'operations/family_details/$1/$2';
$route['family-details/(:any)/(:any)/(:any)'] = 'operations/family_details/$1/$2/$3';


$route['elections-status'] 		= 'operations/elections_status/';
$route['elections-status/(:any)'] 	= 'operations/elections_status/$1';
$route['elections-status/(:any)/(:any)'] = 'operations/elections_status/$1/$2';
$route['elections-status/(:any)/(:any)/(:any)'] = 'operations/elections_status/$1/$2/$3';
$route['elections-status/(:any)/(:any)/(:any)/(:any)'] = 'operations/elections_status/$1/$2/$3/$4';


$route['voting'] 		= 'voting/votes/';
$route['voting/(:any)'] 	= 'voting/votes/$1';
$route['voting/(:any)/(:any)'] = 'voting/votes/$1/$2';


$route['income-master'] 		= 'master/income_master/';
$route['income-master/(:any)'] 	= 'master/income_master/$1';
$route['income-master/(:any)/(:any)'] = 'master/income_master/$1/$2';

$route['settings'] 		= 'master/settings/';
$route['settings/(:any)'] 	= 'master/settings/$1';
$route['settings/(:any)/(:any)'] = 'master/settings/$1/$2';
