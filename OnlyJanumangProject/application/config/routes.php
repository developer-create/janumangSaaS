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

$route['default_controller'] = "login";
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['blockdashboard'] = 'user/blockdashboard';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['profile'] = "user/profile";
$route['profile/(:any)'] = "user/profile/$1";
$route['profileUpdate'] = "user/profileUpdate";
$route['profileUpdate/(:any)'] = "user/profileUpdate/$1";
$route['editservay'] = "user/editservay";
$route['editservay/(:num)'] = "user/editservay/$1";
$route['editservayview/(:num)'] = "user/editservayview/$1";
$route['userservayview/(:num)'] = "user/userservayview/$1";

$route['question/add'] = "question/add";
$route['question/insertquestion'] = "question/insertquestion";
$route['question/questionlisting'] = "question/questionlisting";
$route['question/questiondelete'] = "question/questiondelete";
$route['question/allquestion'] = "question/allquestion";
$route['question/alladd'] = "question/alladd";
$route['question/selectquestion'] = "question/selectquestion";
$route['question/allinsertquestion'] = "question/allinsertquestion";
$route['question/deleteallq'] = "question/deleteallq";

$route['ServayListing'] = 'user/servaylisting';
$route['UserServayListing'] = 'user/userservaylisting';
$route['getVidhanSabhaByDistrict'] = 'ServayController/getVidhanSabhaByDistrict';
$route['IpuserListing'] = 'user/ipuserlisting';

// Servay Controller routes - typo fix for backward compatibility
$route['ServayController/createServayye'] = 'ServayController/createServay';
$route['ServayController/createServay'] = 'ServayController/createServay';

$route['Userwiseipuserlisting/(:any)'] =  "user/userwiseipuserlisting/$1";

// Bulk Upload Routes
$route['mp_vidhan_sabha_member/bulk_upload'] = 'mp_vidhan_sabha_member/bulk_upload';
$route['mp_vidhan_sabha_member/process_bulk_upload'] = 'mp_vidhan_sabha_member/process_bulk_upload';
$route['mp_vidhan_sabha_member/download_template'] = 'mp_vidhan_sabha_member/download_template';

$route['user/jansunwai_bulk_upload'] = 'user/jansunwai_bulk_upload';
$route['user/process_jansunwai_bulk_upload'] = 'user/process_jansunwai_bulk_upload';
$route['user/download_jansunwai_template'] = 'user/download_jansunwai_template';
$route['user/delete_jansunwai/(:num)'] = "user/delete_jansunwai/$1";




$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['changePassword/(:any)'] = "user/changePassword/$1";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";
$route['Usercount'] = "user/usercount";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

$route['roleListing'] = "roles/roleListing";
$route['roleListing/(:num)'] = "roles/roleListing/$1";
$route['roleListing/(:num)/(:num)'] = "roles/roleListing/$1/$2";

// Vidhan Sabha routes
$route['vidhan_sabha'] = "vidhan_sabha/index";
$route['vidhan_sabha/create'] = "vidhan_sabha/create";
$route['vidhan_sabha/store'] = "vidhan_sabha/store";
$route['vidhan_sabha/edit/(:num)'] = "vidhan_sabha/edit/$1";
$route['vidhan_sabha/update/(:num)'] = "vidhan_sabha/update/$1";
$route['vidhan_sabha/delete/(:num)'] = "vidhan_sabha/delete/$1";

// MP Vidhan Sabha Member routes
$route['mp_vidhan_sabha_member'] = "mp_vidhan_sabha_member/index";
$route['mp_vidhan_sabha_member/create'] = "mp_vidhan_sabha_member/create";
$route['mp_vidhan_sabha_member/store'] = "mp_vidhan_sabha_member/store";
$route['mp_vidhan_sabha_member/edit/(:num)'] = "mp_vidhan_sabha_member/edit/$1";
$route['mp_vidhan_sabha_member/update/(:num)'] = "mp_vidhan_sabha_member/update/$1";
$route['mp_vidhan_sabha_member/delete/(:num)'] = "mp_vidhan_sabha_member/delete/$1";
$route['mp_vidhan_sabha_member/get_panchayats_by_block'] = "mp_vidhan_sabha_member/get_panchayats_by_block";
$route['mp_vidhan_sabha_member/get_villages_by_panchayat'] = "mp_vidhan_sabha_member/get_villages_by_panchayat";

// US Code routes
$route['us_code'] = "us_code/index";
$route['us_code/create'] = "us_code/create";
$route['us_code/store'] = "us_code/store";
$route['us_code/edit/(:num)'] = "us_code/edit/$1";
$route['us_code/update/(:num)'] = "us_code/update/$1";
$route['us_code/delete/(:num)'] = "us_code/delete/$1";

// Fix access matrix route
$route['fix_access'] = "fix_access/fix_vidhan_sabha";
// Disable regenerate access matrix to enforce using Roles CRUD only
$route['admin_tools/regenerate_access_matrix'] = 'error_404';

// Tenkar Samiti routes
$route['tenkarsamiti'] = 'TenkarSamiti/index';
$route['tenkarsamiti/create'] = 'TenkarSamiti/create';
$route['tenkarsamiti/store'] = 'TenkarSamiti/store';
$route['tenkarsamiti/edit/(:num)'] = 'TenkarSamiti/edit/$1';
$route['tenkarsamiti/update/(:num)'] = 'TenkarSamiti/update/$1';
$route['tenkarsamiti/delete/(:num)'] = 'TenkarSamiti/delete/$1';
$route['tenkarsamiti/view/(:num)'] = 'TenkarSamiti/view/$1';
$route['tenkarsamiti/members/(:num)'] = 'TenkarSamiti/members/$1';
$route['tenkarsamiti/add_member/(:num)'] = 'TenkarSamiti/add_member/$1';
$route['tenkarsamiti/store_member'] = 'TenkarSamiti/store_member';
$route['tenkarsamiti/edit_member/(:num)'] = 'TenkarSamiti/edit_member/$1';
$route['tenkarsamiti/update_member/(:num)'] = 'TenkarSamiti/update_member/$1';
$route['tenkarsamiti/delete_member/(:num)'] = 'TenkarSamiti/delete_member/$1';
$route['tenkarsamiti/get_booths_by_block'] = 'TenkarSamiti/get_booths_by_block';
$route['tenkarsamiti/get_booth_details'] = 'TenkarSamiti/get_booth_details';

// DP Samiti routes
$route['dpsamiti'] = 'DpSamiti/index';
$route['dpsamiti/create'] = 'DpSamiti/create';
$route['dpsamiti/store'] = 'DpSamiti/store';
$route['dpsamiti/edit/(:num)'] = 'DpSamiti/edit/$1';
$route['dpsamiti/update'] = 'DpSamiti/update';
$route['dpsamiti/delete/(:num)'] = 'DpSamiti/delete/$1';
$route['dpsamiti/view/(:num)'] = 'DpSamiti/view/$1';
$route['dpsamiti/members/(:num)'] = 'DpSamiti/members/$1';
$route['dpsamiti/addMember/(:num)'] = 'DpSamiti/addMember/$1';
$route['dpsamiti/storeMember'] = 'DpSamiti/storeMember';
$route['dpsamiti/editMember/(:num)'] = 'DpSamiti/editMember/$1';
$route['dpsamiti/updateMember'] = 'DpSamiti/updateMember';
$route['dpsamiti/deleteMember/(:num)/(:num)'] = 'DpSamiti/deleteMember/$1/$2';
$route['dpsamiti/get_booths_by_block'] = 'DpSamiti/get_booths_by_block';
$route['dpsamiti/get_booth_details'] = 'DpSamiti/get_booth_details';

// Boring Samiti routes
$route['boringsamiti'] = 'BoringSamiti/index';
$route['boringsamiti/create'] = 'BoringSamiti/create';
$route['boringsamiti/store'] = 'BoringSamiti/store';
$route['boringsamiti/edit/(:num)'] = 'BoringSamiti/edit/$1';
$route['boringsamiti/update/(:num)'] = 'BoringSamiti/update/$1';
$route['boringsamiti/delete/(:num)'] = 'BoringSamiti/delete/$1';
$route['boringsamiti/view/(:num)'] = 'BoringSamiti/view/$1';
$route['boringsamiti/members/(:num)'] = 'BoringSamiti/members/$1';
$route['boringsamiti/add_member/(:num)'] = 'BoringSamiti/add_member/$1';
$route['boringsamiti/store_member'] = 'BoringSamiti/store_member';
$route['boringsamiti/edit_member/(:num)'] = 'BoringSamiti/edit_member/$1';
$route['boringsamiti/update_member/(:num)'] = 'BoringSamiti/update_member/$1';
$route['boringsamiti/delete_member/(:num)'] = 'BoringSamiti/delete_member/$1';
$route['boringsamiti/get_booths_by_block'] = 'BoringSamiti/get_booths_by_block';
$route['boringsamiti/get_booth_details'] = 'BoringSamiti/get_booth_details';




// Mandir Samiti routes
$route['mandirsamiti'] = 'MandirSamiti/index';
$route['mandirsamiti/create'] = 'MandirSamiti/create';
$route['mandirsamiti/store'] = 'MandirSamiti/store';
$route['mandirsamiti/edit/(:num)'] = 'MandirSamiti/edit/$1';
$route['mandirsamiti/update'] = 'MandirSamiti/update';
$route['mandirsamiti/delete/(:num)'] = 'MandirSamiti/delete/$1';
$route['mandirsamiti/view/(:num)'] = 'MandirSamiti/view/$1';
$route['mandirsamiti/members/(:num)'] = 'MandirSamiti/members/$1';
$route['mandirsamiti/addMember/(:num)'] = 'MandirSamiti/addMember/$1';
$route['mandirsamiti/storeMember'] = 'MandirSamiti/storeMember';
$route['mandirsamiti/editMember/(:num)'] = 'MandirSamiti/editMember/$1';
$route['mandirsamiti/updateMember'] = 'MandirSamiti/updateMember';
$route['mandirsamiti/deleteMember/(:num)/(:num)'] = 'MandirSamiti/deleteMember/$1/$2';
$route['mandirsamiti/get_booths_by_block'] = 'MandirSamiti/get_booths_by_block';
$route['mandirsamiti/get_booth_details'] = 'MandirSamiti/get_booth_details';

// Ganesh Samiti routes
$route['ganeshsamiti'] = 'GaneshSamiti/index';
$route['ganeshsamiti/create'] = 'GaneshSamiti/create';
$route['ganeshsamiti/store'] = 'GaneshSamiti/store';
$route['ganeshsamiti/edit/(:num)'] = 'GaneshSamiti/edit/$1';
$route['ganeshsamiti/update/(:num)'] = 'GaneshSamiti/update/$1';
$route['ganeshsamiti/delete/(:num)'] = 'GaneshSamiti/delete/$1';
$route['ganeshsamiti/view/(:num)'] = 'GaneshSamiti/view/$1';
$route['ganeshsamiti/members/(:num)'] = 'GaneshSamiti/members/$1';
$route['ganeshsamiti/add_member/(:num)'] = 'GaneshSamiti/add_member/$1';
$route['ganeshsamiti/store_member'] = 'GaneshSamiti/store_member';
$route['ganeshsamiti/edit_member/(:num)'] = 'GaneshSamiti/edit_member/$1';
$route['ganeshsamiti/update_member/(:num)'] = 'GaneshSamiti/update_member/$1';
$route['ganeshsamiti/delete_member/(:num)'] = 'GaneshSamiti/delete_member/$1';
$route['ganeshsamiti/get_booths_by_block'] = 'GaneshSamiti/get_booths_by_block';
$route['ganeshsamiti/get_booth_details'] = 'GaneshSamiti/get_booth_details';



// Backward compatibility routes
$route['ganeshsamiti/add'] = 'GaneshSamiti/add';
$route['ganeshsamiti/addNewGaneshSamiti'] = 'GaneshSamiti/addNewGaneshSamiti';
$route['ganeshsamiti/editGaneshSamiti'] = 'GaneshSamiti/editGaneshSamiti';
$route['ganeshsamiti/deleteGaneshSamiti'] = 'GaneshSamiti/deleteGaneshSamiti';
$route['ganeshsamiti/checkSerialNumberExists'] = 'GaneshSamiti/checkSerialNumberExists';

// Kabbadi Samiti routes
$route['kabbadisamiti'] = 'KabbadiSamiti/index';
$route['kabbadisamiti/add'] = 'KabbadiSamiti/add';
$route['kabbadisamiti/store'] = 'KabbadiSamiti/store';
$route['kabbadisamiti/edit/(:num)'] = 'KabbadiSamiti/edit/$1';
$route['kabbadisamiti/update/(:num)'] = 'KabbadiSamiti/update/$1';
$route['kabbadisamiti/delete/(:num)'] = 'KabbadiSamiti/delete/$1';
$route['kabbadisamiti/view/(:num)'] = 'KabbadiSamiti/view/$1';
$route['kabbadisamiti/members/(:num)'] = 'KabbadiSamiti/members/$1';
$route['kabbadisamiti/add_member/(:num)'] = 'KabbadiSamiti/add_member/$1';
$route['kabbadisamiti/store_member'] = 'KabbadiSamiti/store_member';
$route['kabbadisamiti/edit_member/(:num)'] = 'KabbadiSamiti/edit_member/$1';
$route['kabbadisamiti/update_member/(:num)'] = 'KabbadiSamiti/update_member/$1';
$route['kabbadisamiti/delete_member/(:num)'] = 'KabbadiSamiti/delete_member/$1';
$route['kabbadisamiti/get_booths_by_block'] = 'KabbadiSamiti/get_booths_by_block';
$route['kabbadisamiti/get_booth_details'] = 'KabbadiSamiti/get_booth_details';
$route['kabbadisamiti/next_unique_id'] = 'KabbadiSamiti/next_unique_id';
$route['kabbadisamiti/add_samiti_type'] = 'KabbadiSamiti/add_samiti_type';

// Samiti routes
$route['samiti'] = 'Samiti/index';
$route['samiti/add'] = 'Samiti/add';
$route['samiti/store'] = 'Samiti/store';
$route['samiti/edit/(:num)'] = 'Samiti/edit/$1';
$route['samiti/update/(:num)'] = 'Samiti/update/$1';
$route['samiti/delete/(:num)'] = 'Samiti/delete/$1';
$route['samiti/view/(:num)'] = 'Samiti/view/$1';

// Block routes
$route['block'] = 'Block/index';
$route['block/add'] = 'Block/add';
$route['block/store'] = 'Block/store';
$route['block/edit/(:num)'] = 'Block/edit/$1';
$route['block/update/(:num)'] = 'Block/update/$1';
$route['block/delete/(:num)'] = 'Block/delete/$1';
$route['block/view/(:num)'] = 'Block/view/$1';

// Booth routes
$route['booth'] = 'Booth/index';
$route['booth/add'] = 'Booth/add';
$route['booth/store'] = 'Booth/store';
$route['booth/edit/(:num)'] = 'Booth/edit/$1';
$route['booth/update/(:num)'] = 'Booth/update/$1';
$route['booth/delete/(:num)'] = 'Booth/delete/$1';
$route['booth/view/(:num)'] = 'Booth/view/$1';

// Panchayat routes
$route['panchayat'] = 'Panchayat/index';
$route['panchayat/add'] = 'Panchayat/add';
$route['panchayat/store'] = 'Panchayat/store';
$route['panchayat/edit/(:num)'] = 'Panchayat/edit/$1';
$route['panchayat/update/(:num)'] = 'Panchayat/update/$1';
$route['panchayat/delete/(:num)'] = 'Panchayat/delete/$1';
$route['panchayat/view/(:num)'] = 'Panchayat/view/$1';

// Village routes
$route['village'] = 'Village/index';
$route['village/add'] = 'Village/add';
$route['village/store'] = 'Village/store';
$route['village/edit/(:num)'] = 'Village/edit/$1';
$route['village/update/(:num)'] = 'Village/update/$1';
$route['village/delete/(:num)'] = 'Village/delete/$1';
$route['village/view/(:num)'] = 'Village/view/$1';

// Events routes
$route['events'] = 'Events/index';
$route['events/add'] = 'Events/add';
$route['events/create'] = 'Events/create';
$route['events/store'] = 'Events/store';
$route['events/edit/(:num)'] = 'Events/edit/$1';
$route['events/update/(:num)'] = 'Events/update/$1';
$route['events/delete/(:num)'] = 'Events/delete/$1';
$route['events/view/(:num)'] = 'Events/view/$1';
$route['events/connect-google-calendar'] = 'Events/connect_google_calendar';
$route['events/connect_google_calendar'] = 'Events/connect_google_calendar';
$route['events/google-calendar-callback'] = 'Events/google_calendar_callback';
$route['events/google_calendar_callback'] = 'Events/google_calendar_callback';
$route['events/disconnect-google-calendar'] = 'Events/disconnect_google_calendar';
$route['events/disconnect_google_calendar'] = 'Events/disconnect_google_calendar';

// Events API (JSON; same fields as events/store)
$route['api/event_create'] = 'api/event_create';
$route['api/event_list'] = 'api/event_list';
$route['api/event_list_by_date'] = 'api/event_list_by_date';




// Voter routes
$route['voter'] = 'Voter/index';
$route['voter/create'] = 'Voter/create';
$route['voter/store'] = 'Voter/store';
$route['voter/edit/(:num)'] = 'Voter/edit/$1';
$route['voter/update/(:num)'] = 'Voter/update/$1';
$route['voter/delete/(:num)'] = 'Voter/delete/$1';
$route['voter/get_sub_cast_options'] = 'Voter/get_sub_cast_options';

// Activity Log routes
$route['activitylog'] = 'ActivityLog/index';
$route['activitylog/getActivityLogsAjax'] = 'ActivityLog/getActivityLogsAjax';
$route['activitylog/report'] = 'ActivityLog/report';
$route['database_setup/activity_tables'] = 'Database_setup/activity_tables';
$route['database_setup/create_tables'] = 'Database_setup/create_tables';
$route['database_setup/debug_timezone'] = 'Database_setup/debug_timezone';
$route['database_setup/fix_sessions'] = 'Database_setup/fix_sessions';
$route['activitylog/export'] = 'ActivityLog/export';
$route['activitylog/view/(:num)'] = 'ActivityLog/view/$1';

// Visitors routes
$route['visitors'] = 'Visitors/index';
$route['visitors/add'] = 'Visitors/add';
$route['visitors/store'] = 'Visitors/store';
$route['visitors/edit/(:num)'] = 'Visitors/edit/$1';
$route['visitors/update/(:num)'] = 'Visitors/update/$1';
$route['visitors/delete/(:num)'] = 'Visitors/delete/$1';
$route['visitors/view/(:num)'] = 'Visitors/view/$1';

// Phone Directory routes
$route['phonedirectory'] = 'PhoneDirectory/index';
$route['phonedirectory/add'] = 'PhoneDirectory/add';
$route['phonedirectory/store'] = 'PhoneDirectory/store';
$route['phonedirectory/bulk_upload'] = 'PhoneDirectory/bulk_upload';
$route['phonedirectory/process_bulk_upload'] = 'PhoneDirectory/process_bulk_upload';
$route['phonedirectory/download_template'] = 'PhoneDirectory/download_template';
$route['phonedirectory/edit/(:num)'] = 'PhoneDirectory/edit/$1';
$route['phonedirectory/update/(:num)'] = 'PhoneDirectory/update/$1';
$route['phonedirectory/delete/(:num)'] = 'PhoneDirectory/delete/$1';
$route['phonedirectory/view/(:num)'] = 'PhoneDirectory/view/$1';

// Dispatch Register routes
$route['dispatchregister'] = 'DispatchRegister/index';
$route['dispatchregister/create'] = 'DispatchRegister/create';
$route['dispatchregister/store'] = 'DispatchRegister/store';
$route['dispatchregister/edit/(:num)'] = 'DispatchRegister/edit/$1';
$route['dispatchregister/update/(:num)'] = 'DispatchRegister/update/$1';
$route['dispatchregister/delete/(:num)'] = 'DispatchRegister/delete/$1';
$route['dispatchregister/view/(:num)'] = 'DispatchRegister/view/$1';
$route['dispatchregister/get_panchayats_by_block'] = 'DispatchRegister/get_panchayats_by_block';
$route['dispatchregister/get_villages_by_panchayat'] = 'DispatchRegister/get_villages_by_panchayat';
$route['dispatchregister/get_villages_by_block'] = 'DispatchRegister/get_villages_by_block';

// Bhagoria Samiti routes
$route['bhagoriasamiti'] = 'BhagoriaSamiti/index';
$route['bhagoriasamiti/create'] = 'BhagoriaSamiti/create';
$route['bhagoriasamiti/store'] = 'BhagoriaSamiti/store';
$route['bhagoriasamiti/edit/(:num)'] = 'BhagoriaSamiti/edit/$1';
$route['bhagoriasamiti/update/(:num)'] = 'BhagoriaSamiti/update/$1';
$route['bhagoriasamiti/delete/(:num)'] = 'BhagoriaSamiti/delete/$1';
$route['bhagoriasamiti/view/(:num)'] = 'BhagoriaSamiti/view/$1';
$route['bhagoriasamiti/members/(:num)'] = 'BhagoriaSamiti/members/$1';
$route['bhagoriasamiti/add_member/(:num)'] = 'BhagoriaSamiti/add_member/$1';
$route['bhagoriasamiti/store_member'] = 'BhagoriaSamiti/store_member';
$route['bhagoriasamiti/edit_member/(:num)'] = 'BhagoriaSamiti/edit_member/$1';
$route['bhagoriasamiti/update_member/(:num)'] = 'BhagoriaSamiti/update_member/$1';
$route['bhagoriasamiti/delete_member/(:num)'] = 'BhagoriaSamiti/delete_member/$1';

// Nirman Samiti routes
$route['nirmansamiti'] = 'NirmanSamiti/index';
$route['nirmansamiti/create'] = 'NirmanSamiti/create';
$route['nirmansamiti/store'] = 'NirmanSamiti/store';
$route['nirmansamiti/edit/(:num)'] = 'NirmanSamiti/edit/$1';
$route['nirmansamiti/update/(:num)'] = 'NirmanSamiti/update/$1';
$route['nirmansamiti/delete/(:num)'] = 'NirmanSamiti/delete/$1';
$route['nirmansamiti/view/(:num)'] = 'NirmanSamiti/view/$1';
$route['nirmansamiti/members/(:num)'] = 'NirmanSamiti/members/$1';
$route['nirmansamiti/add_member/(:num)'] = 'NirmanSamiti/add_member/$1';
$route['nirmansamiti/store_member'] = 'NirmanSamiti/store_member';
$route['nirmansamiti/edit_member/(:num)'] = 'NirmanSamiti/edit_member/$1';
$route['nirmansamiti/update_member/(:num)'] = 'NirmanSamiti/update_member/$1';
$route['nirmansamiti/delete_member/(:num)'] = 'NirmanSamiti/delete_member/$1';
$route['nirmansamiti/get_booths_by_block'] = 'NirmanSamiti/get_booths_by_block';
$route['nirmansamiti/get_booth_details'] = 'NirmanSamiti/get_booth_details';

// Booth Samiti routes
$route['boothsamiti'] = 'BoothSamiti/index';
$route['boothsamiti/create'] = 'BoothSamiti/create';
$route['boothsamiti/store'] = 'BoothSamiti/store';
$route['boothsamiti/edit/(:num)'] = 'BoothSamiti/edit/$1';
$route['boothsamiti/update/(:num)'] = 'BoothSamiti/update/$1';
$route['boothsamiti/delete/(:num)'] = 'BoothSamiti/delete/$1';
$route['boothsamiti/view/(:num)'] = 'BoothSamiti/view/$1';
$route['boothsamiti/members/(:num)'] = 'BoothSamiti/members/$1';
$route['boothsamiti/add_member/(:num)'] = 'BoothSamiti/add_member/$1';
$route['boothsamiti/store_member'] = 'BoothSamiti/store_member';
$route['boothsamiti/edit_member/(:num)'] = 'BoothSamiti/edit_member/$1';
$route['boothsamiti/update_member/(:num)'] = 'BoothSamiti/update_member/$1';
$route['boothsamiti/delete_member/(:num)'] = 'BoothSamiti/delete_member/$1';
$route['boothsamiti/get_booths_by_block'] = 'BoothSamiti/get_booths_by_block';
$route['boothsamiti/get_booth_details'] = 'BoothSamiti/get_booth_details';

// Block Samiti routes
$route['blocksamiti'] = 'BlockSamiti/index';
$route['blocksamiti/create'] = 'BlockSamiti/create';
$route['blocksamiti/store'] = 'BlockSamiti/store';
$route['blocksamiti/edit/(:num)'] = 'BlockSamiti/edit/$1';
$route['blocksamiti/update/(:num)'] = 'BlockSamiti/update/$1';
$route['blocksamiti/delete/(:num)'] = 'BlockSamiti/delete/$1';
$route['blocksamiti/view/(:num)'] = 'BlockSamiti/view/$1';
$route['blocksamiti/members/(:num)'] = 'BlockSamiti/members/$1';
$route['blocksamiti/add_member/(:num)'] = 'BlockSamiti/add_member/$1';
$route['blocksamiti/store_member'] = 'BlockSamiti/store_member';
$route['blocksamiti/edit_member/(:num)'] = 'BlockSamiti/edit_member/$1';
$route['blocksamiti/update_member/(:num)'] = 'BlockSamiti/update_member/$1';
$route['blocksamiti/delete_member/(:num)'] = 'BlockSamiti/delete_member/$1';
$route['blocksamiti/get_booths_by_block'] = 'BlockSamiti/get_booths_by_block';
$route['blocksamiti/get_booth_details'] = 'BlockSamiti/get_booth_details';

// Worktype routes
$route['worktype'] = 'Worktype/index';
$route['worktype/add'] = 'Worktype/add';
$route['worktype/store'] = 'Worktype/store';
$route['worktype/edit/(:num)'] = 'Worktype/edit/$1';
$route['worktype/update/(:num)'] = 'Worktype/update/$1';
$route['worktype/delete/(:num)'] = 'Worktype/delete/$1';
$route['worktype/view/(:num)'] = 'Worktype/view/$1';

// SubtypeOfWork routes
$route['subtypeofwork'] = 'SubtypeOfWork/index';
$route['subtypeofwork/create'] = 'SubtypeOfWork/create';
$route['subtypeofwork/store'] = 'SubtypeOfWork/store';
$route['subtypeofwork/edit/(:num)'] = 'SubtypeOfWork/edit/$1';
$route['subtypeofwork/update/(:num)'] = 'SubtypeOfWork/update/$1';
$route['subtypeofwork/delete/(:num)'] = 'SubtypeOfWork/delete/$1';

// District routes
$route['district'] = 'District/index';
$route['district/add'] = 'District/add';
$route['district/store'] = 'District/store';
$route['district/edit/(:num)'] = 'District/edit/$1';
$route['district/update/(:num)'] = 'District/update/$1';
$route['district/delete/(:num)'] = 'District/delete/$1';
$route['district/view/(:num)'] = 'District/view/$1';

// Project Summary routes
$route['projectsummary'] = 'ProjectSummary/index';
$route['projectsummary/add'] = 'ProjectSummary/add';
$route['projectsummary/store'] = 'ProjectSummary/store';
$route['projectsummary/edit/(:num)'] = 'ProjectSummary/edit/$1';
$route['projectsummary/update/(:num)'] = 'ProjectSummary/update/$1';
$route['projectsummary/delete/(:num)'] = 'ProjectSummary/delete/$1';
$route['projectsummary/view/(:num)'] = 'ProjectSummary/view/$1';
$route['projectsummary/getComments/(:num)'] = 'ProjectSummary/getComments/$1';
$route['projectsummary/addComment'] = 'ProjectSummary/addComment';

// Call Management routes
$route['callmanagement'] = 'CallManagement/index';
$route['callmanagement/create'] = 'CallManagement/create';
$route['callmanagement/store'] = 'CallManagement/store';
$route['callmanagement/add'] = 'CallManagement/add';
$route['callmanagement/edit/(:num)'] = 'CallManagement/edit/$1';
$route['callmanagement/update/(:num)'] = 'CallManagement/update/$1';
$route['callmanagement/view/(:num)'] = 'CallManagement/view/$1';
$route['callmanagement/delete/(:num)'] = 'CallManagement/delete/$1';

// In Docs routes
$route['indocs'] = 'InDocs/index';
$route['indocs/create'] = 'InDocs/create';
$route['indocs/store'] = 'InDocs/store';
$route['indocs/edit/(:num)'] = 'InDocs/edit/$1';
$route['indocs/update/(:num)'] = 'InDocs/update/$1';
$route['indocs/delete/(:num)'] = 'InDocs/delete/$1';

// Inward Register routes
$route['inwardregister'] = 'InwardRegister/index';
$route['inwardregister/create'] = 'InwardRegister/create';
$route['inwardregister/store'] = 'InwardRegister/store';
$route['inwardregister/edit/(:num)'] = 'InwardRegister/edit/$1';
$route['inwardregister/update/(:num)'] = 'InwardRegister/update/$1';
$route['inwardregister/delete/(:num)'] = 'InwardRegister/delete/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
