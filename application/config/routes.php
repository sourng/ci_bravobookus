<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Accomondations
$route['hotels.html/(.+)$'] = 'accomondations/hotels_details/$1';

$route['hotels.html'] = 'hotels';
$route['hotelspage.html']='hotels';


$route['hotels'] = "hotels/listhotel";
$route['hotels/listhotel(:any)'] = "hotels/listhotel/$1";
$route['hotels/listhotel/(:any)/(:any)'] = "hotels/listhotel/$1/$2";
$route['hotels/listhotel/(:any)/(:any)/(:any)'] = "hotels/listhotel/$1/$2/$3";
$route['hotels/listhotel/(:any)/(:any)/(:any)/(:any)'] = "hotels/listhotel/$1/$2/$3/$4"; 


// ==============================================

/*admin*/
$route['admin'] = 'Admin_Login/index';
$route['signin.html'] = 'Admin_Login/index';

//User Signup
$route['signup.html'] = 'Admin_Login/signup';
$route['admin/guest_register'] = 'Admin_Login/guest_register';


//When login button click
$route['admin/verifylogin'] = 'Admin_Login/verifylogin';
//$route['admin/login/validate_credentials'] = 'user/validate_credentials';

// After Login Success
$route['admin/dashboard'] = 'Admin_dashboard/index';
$route['dashboard.html'] = 'Admin_dashboard/index';

$route['booking.html'] = 'Admin_dashboard/booking';
// (:any)
$route['booking.html/(:any)'] = 'Admin_dashboard/booking/$1';
$route['booking.html/(:any)/(:any)'] = 'Admin_dashboard/booking/$1/$2';
$route['guests.html'] = 'Admin_dashboard/guests';

$route['profile.html'] = 'Admin_dashboard/profile';

$route['invoice-print.html'] = 'Admin_dashboard/invoice_print';


// Hotels Management

$route['list-hotels.html'] = 'Admin_dashboard/list_hotels';
$route['add-hotels.html'] = 'Admin_dashboard/add_hotels';
$route['remove-hotels.html'] = 'Admin_dashboard/removed_hotels';
$route['blocked-hotels.html'] = 'Admin_dashboard/blocked_hotels';


// Vechicles Management
// list_vechicles
$route['list-vechicles.html'] = 'Admin_dashboard/list_vechicles';
// list_vechicles_blocked
$route['vechicle-blocked.html'] = 'Admin_dashboard/list_vechicles_blocked';

//show_vechicles

// $route['list-vechicles.html'] = 'Admin_dashboard/show_vechicles';

$route['add-vechicles.html'] = 'Admin_dashboard/add_vechicle';


// Logout
$route['logout'] = 'Admin_Login/logout';
