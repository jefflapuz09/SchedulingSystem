<?php
//section_management
Route::get('/admin/section_management','Admin\CourseOfferingController@section_management');
Route::get('/admin/section_management/archive','Admin\CourseOfferingController@section_management_archive');
Route::post('/admin/section_management/post','Admin\CourseOfferingController@new_section');
Route::get('/admin/section_management/archive/{section_id}','Admin\CourseOfferingController@archive_section');
Route::get('/ajax/admin/section_management/edit_section','Admin\Ajax\CourseOfferingAjax@edit_section');
Route::post('/admin/section_management/update','Admin\CourseOfferingController@update_section');

//course offerings
Route::get('/admin/course_offerings','Admin\CourseOfferingController@course_offering_index');
Route::get('/admin/course_offerings/{program_code}','Admin\CourseOfferingController@course_offering_program');
Route::get('/ajax/admin/course_offerings/get_courses','Admin\Ajax\CourseOfferingAjax@get_courses');
Route::get('/ajax/admin/course_offerings/get_courses_offered','Admin\Ajax\CourseOfferingAjax@get_courses_offered');
Route::get('/ajax/admin/course_offerings/add_course_offer','Admin\Ajax\CourseOfferingAjax@add_course_offer');
Route::get('/ajax/admin/course_offerings/remove_course_offer','Admin\Ajax\CourseOfferingAjax@remove_course_offer');
Route::get('/ajax/admin/course_offerings/get_sections','Admin\Ajax\CourseOfferingAjax@get_sections');

//Room Management
Route::get('/admin/room_management','Admin\CourseOfferingController@room_management');
Route::get('/admin/room_management/archive','Admin\CourseOfferingController@room_management_archive');
Route::post('/admin/room_management/post','Admin\CourseOfferingController@new_room');
Route::get('/admin/room_management/archive/{room_id}','Admin\CourseOfferingController@archive_room');
Route::get('/ajax/admin/room_management/edit_room','Admin\Ajax\CourseOfferingAjax@edit_room');
Route::post('/admin/room_management/update','Admin\CourseOfferingController@update_room');


//course scheduling
Route::get('/admin/course_scheduling','Admin\CourseScheduleController@course_schedule');
Route::get('/ajax/admin/course_scheduling/get_sections','Admin\Ajax\CourseScheduleAjax@get_sections');
Route::get('/ajax/admin/course_scheduling/get_courses_offered','Admin\Ajax\CourseScheduleAjax@get_courses_offered');
Route::get('/admin/course_scheduling/schedule/{offering_id}/{section_name}','Admin\CourseScheduleController@add_schedule');
Route::get('/ajax/admin/course_scheduling/get_rooms_available','Admin\Ajax\CourseScheduleAjax@get_rooms_available');
Route::post('/admin/course_scheduling/add_schedule','Admin\CourseScheduleController@add_schedule_post');
Route::get('/admin/course_scheduling/remove_schedule/{schedule_id}/{offering_id}','Admin\CourseScheduleController@remove_schedule');
Route::get('/admin/course_scheduling/attach_schedule/{schedule_id}/{offering_id}','Admin\CourseScheduleController@attach_schedule');
Route::get('/admin/course_scheduling/delete_schedule/{schedule_id}/{offering_id}','Admin\CourseScheduleController@delete_schedule');


//faculty loading
Route::get('/admin/faculty_loading','Admin\FacultyLoadingController@faculty_loading');
Route::get('/ajax/admin/faculty_loading/courses_to_load','Admin\Ajax\FacultyLoadingAjax@courses_to_load');
Route::get('/ajax/admin/faculty_loading/current_load','Admin\Ajax\FacultyLoadingAjax@current_load');
Route::get('/ajax/admin/faculty_loading/add_faculty_load','Admin\Ajax\FacultyLoadingAjax@add_faculty_load');
Route::get('/ajax/admin/faculty_loading/remove_faculty_load','Admin\Ajax\FacultyLoadingAjax@remove_faculty_load');
Route::get('/ajax/admin/faculty_loading/search_courses','Admin\Ajax\FacultyLoadingAjax@search_courses');
Route::get('/ajax/admin/faculty_loading/reloadnotif','Admin\Ajax\FacultyLoadingAjax@reloadnotif');
Route::get('/admin/faculty_loading/generate_schedule/{instructor_id}','Admin\FacultyLoadingController@generate_schedule');

Route::get('/admin/instructor/view_instructor_account','Users\Instructor\ViewInstructorsController@view_add');
Route::get('/admin/instructor/view_instructor_account/{id}','Users\Instructor\ViewInstructorsController@view_info');

//Notifications
Route::get('/admin/notification','Admin\NotificationController@notifications');

//Instructor Portal
Route::get('/instructor/faculty_loading','Instructor\FacultyLoading@faculty_loading');
Route::get('/ajax/instructor/get_offer_load','Instructor\Ajax\FacultyLoadingAjax@get_offer_load');
Route::get('/ajax/instructor/accept_load','Instructor\Ajax\FacultyLoadingAjax@accept_load');
Route::get('/ajax/instructor/reject_offer','Instructor\Ajax\FacultyLoadingAjax@reject_offer');
Route::get('/ajax/instructor/reloadtabular','Instructor\Ajax\FacultyLoadingAjax@reloadtabular');
Route::get('/ajax/instructor/reloadcalendar','Instructor\Ajax\FacultyLoadingAjax@reloadcalendar');

Route::get('/ajax/curriculum_management/edit_modal','Admin\Ajax\CourseOfferingAjax@edit_modal');
Route::post('/curriculum_management/edit_curriculum','Admin\CurriculumController@edit_curriculum');

Route::post('/default/change_password','HomeController@default_pass');
Route::get('/403',function(){
    return view('adminlte::errors.404');
});

//Superadmin
Route::get('/superadmin/register_admin','SuperAdmin\SuperAdminController@register_admin');
Route::post('/superadmin/register_admin/save','SuperAdmin\SuperAdminController@register_admin_save');

Route::get('/account/change_password','Account\AccountController@change_pass');
Route::post('/account/change_pass','Account\AccountController@change_password');

Route::get('/ajax/admin/faculty_loading/get_units_loaded','Admin\Ajax\FacultyLoadingAjax@get_units_loaded');
Route::get('/ajax/admin/faculty_loading/override_add','Admin\Ajax\FacultyLoadingAjax@override_add');

Route::get('/admin/reports/rooms_occupied','Admin\ReportController@room_occupied');
Route::get('/admin/reports/print_rooms_occupied/{room}','Admin\ReportController@print_room_occupied');
Route::get('/ajax/admin/reports/get_rooms_occupied','Admin\Ajax\ReportAjax@get_room_occupied');

Route::get('/add/unit_load',function(){
   $users = \App\User::where('accesslevel',1)->get();
    foreach($users as $user){
        $info = \App\instructors_infos::where('instructor_id',$user->id)->first();
        if(!empty($info)){
           $record = new \App\UnitsLoad;
           $record->instructor_id = $user->id;
           $record->employee_type = $info->employee_type;
           if($info->employee_type == 'Full Time'){
               $record->units = 36;
           }else{
               $record->units = 15;
           }
           $record->save();
        }
    } 
});