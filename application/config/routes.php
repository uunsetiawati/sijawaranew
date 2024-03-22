<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller']                    = 'guest';
$route['404_override']                          = '';
$route['translate_uri_dashes']                  = FALSE;

$route['guest/category']                        = 'guest/courseCategories';
$route['guest/(:any)']                          = 'error/error_404';

// LOGIN
$route['login']                                 = 'AuthController';
$route['register']                              = 'RegisterController';
$route['account/verify']                        = 'RegisterController/account_verify';
$route['logout']                                = 'AuthController/logout';
$route['verification']                          = 'AuthController/verification';
$route['forgotPassword']                        = 'AuthController/forgotPassword';
$route['forgotPasswordConfirm']                 = 'AuthController/forgotPasswordConfirm';
$route['resetPassword/(:any)']                  = 'AuthController/resetPassword/$1';
$route['resetPasswordSuccess']                  = 'AuthController/resetPasswordSuccess';
$route['about']                                 = 'AuthController/about';
$route['send/mail']                             = 'Guest/send_message_to_email';

// USER
$route['event']                                 = 'guest_controller/EventGuest';
$route['event/(:num)']                          = 'guest_controller/EventGuest';
$route['event/detail']                          = 'guest_controller/EventGuest/detailEvent';
$route['event/search']                          = 'guest_controller/EventGuest/searchEvent';
$route['event/detail/(:any)']                   = 'guest_controller/EventGuest/detailEvent/$1';

$route['course']                                = 'guest_controller/CourseGuest';
$route['course/category']                       = 'guest_controller/CourseGuest/getFilterByKat';
$route['course/category/(:num)']                = 'guest_controller/CourseGuest/getFilterByKat';
$route['course/detail/(:any)']                  = 'guest_controller/CourseGuest/detailCourse/$1';
$route['course/info/(:any)']                    = 'guest_controller/CourseGuest/infoCourse/$1';
$route['course/item']                           = 'guest_controller/CourseGuest/getDetailItemCourse/';
$route['course/item/mapping']                   = 'guest_controller/CourseGuest/getMappingCourse/';
$route['course/search']                         = 'guest_controller/CourseGuest/searchCourse';
$route['course/detail']                         = 'guest_controller/CourseGuest/detailCourse';
$route['course/quiz/evaluation']                = 'guest_controller/CourseGuest/QuizEvaluation';
$route['course/finish']                         = 'guest_controller/CourseGuest/Finish';

$route['checkout']                              = 'guest_controller/CheckoutGuest';
$route['add/order']                             = 'guest_controller/CheckoutGuest/addOrder';
$route['delete/order']                          = 'guest_controller/CheckoutGuest/deleteOrder';
$route['purchase']                              = 'guest_controller/CheckoutGuest/purchase';
$route['check_payment_status']                  = 'guest_controller/CheckoutGuest/check_status';
$route['delete/pay']                            = 'guest_controller/CheckoutGuest/DeleteTrans';

$route['profile']                               = 'guest_controller/ProfileGuest';
$route['profile/update']                        = 'guest_controller/ProfileGuest/update_profile';
$route['about']                                 = 'guest_controller/ProfileGuest/about';
$route['profile/academic']                      = 'guest_controller/ProfileGuest/academic';
$route['profile/academic/change']               = 'guest_controller/ProfileGuest/change_academic';
$route['profile/mycourses']                     = 'guest_controller/ProfileGuest/mycourses';
$route['profile/myevents']                      = 'guest_controller/ProfileGuest/myevents';
$route['profile/myebook']                       = 'guest_controller/ProfileGuest/myebook';
$route['profile/document']                      = 'guest_controller/ProfileGuest/document';
$route['profile/document/change']               = 'guest_controller/ProfileGuest/change_document';
$route['profile/password']                      = 'guest_controller/ProfileGuest/password';
$route['profile/overview']                      = 'guest_controller/ProfileGuest/overview';
$route['profile/courses']                       = 'guest_controller/ProfileGuest/courses';
$route['profile/apply/instructor']              = 'guest_controller/ProfileGuest/apply_asinstructor';

$route['ebook']                                 = 'guest_controller/EbookGuest';
$route['ebook/list']                            = 'guest_controller/EbookGuest/listEbook';

$route['promo']                                 = 'guest_controller/PromoGuest';

// ADMIN
$route['dashboard']                             = 'admin_controller/DashboardController';
$route['chart/revenue']                         = 'admin_controller/DashboardController/get_chart_revenue';

$route['manage/activity/course']                = 'admin_controller/CourseController';
$route['manage/activity/course/add']            = 'admin_controller/CourseController/add_course';
$route['manage/activity/course/update/(:any)']  = 'admin_controller/CourseController/update_course/$1';
$route['manage/activity/course/delete/(:any)']  = 'admin_controller/CourseController/delete_course/$1';

$route['manage/activity/event']                 = 'admin_controller/EventController';
$route['manage/activity/event/add']             = 'admin_controller/EventController/add_event';
$route['manage/activity/event/update/(:any)']   = 'admin_controller/EventController/update_event/$1';
$route['manage/activity/event/delete/(:any)']   = 'admin_controller/EventController/delete_event/$1';

$route['manage/ebook']                          = 'admin_controller/EbookController';
$route['manage/ebook/add']                      = 'admin_controller/EbookController/add_book';
$route['manage/ebook/update/(:any)']            = 'admin_controller/EbookController/update_book/$1';
$route['manage/ebook/delete/(:any)']            = 'admin_controller/EbookController/delete_book/$1';
$route['manage/ebook/preview/(:any)']           = 'admin_controller/EbookController/prev_book/$1';

$route['manage/category']                       = 'admin_controller/CategoryController';
$route['manage/category/add']                   = 'admin_controller/CategoryController/insert_category';
$route['manage/category/update']                = 'admin_controller/CategoryController/update_category';
$route['manage/category/delete']                = 'admin_controller/CategoryController/delete_category';

$route['manage/user']                           = 'admin_controller/UserController/ManageUser';
$route['manage/user/add']                       = 'admin_controller/UserController/add_user';
$route['manage/user/update/(:any)']             = 'admin_controller/UserController/update_user/$1';
$route['manage/user/delete/(:any)']             = 'admin_controller/UserController/delete_user/$1';

$route['manage/promo']                          = 'admin_controller/PromoController';
$route['manage/promo/add']                      = 'admin_controller/PromoController/add_promo';
$route['manage/promo/update']                   = 'admin_controller/PromoController/update_promo';
$route['manage/promo/delete']                   = 'admin_controller/PromoController/delete_promo';

$route['instructor']                            = 'admin_controller/instructorController';
$route['manage/instructor']                     = 'admin_controller/instructorController/Instructor';
$route['manage/instructor/verify']              = 'admin_controller/instructorController/Instructor_verify';
