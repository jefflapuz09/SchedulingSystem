 <?php
include 'web2.php';
include 'web3.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
    
Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

//curriculum management
Route::get('/admin/curiculum_management/curriculum','Admin\CurriculumController@index');
Route::get('/admin/curriculum_management/view_curriculums/{program_code}', 'Admin\CurriculumController@viewcurricula');
Route::get('/admin/curriculum_management/list_curriculum/{program_code}/{curriculum_year}','Admin\CurriculumController@listcurriculum');

//add curriculum
Route::get('/admin/curriculum_management/add_curriculum','Admin\AddCurriculumController@index');
Route::get('/admin/curriculum_management/upload_curriculum', 'Admin\UploadCurriculumController@index');
Route::get('/admin/curriculum_management/curriculum/addcourse','RegistrarCollege\CurriculumManagement\CurriculumController@add_course');
Route::post('admin/curriculum_management/upload/save_changes','Admin\UploadCurriculumController@save_changes');


//instructor
Route::get('/admin/instructor/add_instructor','Users\Instructor\ViewInstructorsController@index');
Route::post('/admin/instructor/add_new_instructor', 'Users\Instructor\ViewInstructorsController@add');
Route::get('/admin/instructor/view_instructor','Users\Instructor\ViewInstructorController@');
Route::post('/admin/instructor/update/{id}', [
    'uses' => 'Users\Instructor\ViewInstructorsController@updateinstructor',
    'as' => 'admin.updateinstructor'
]);

Route::get('/registrar_college/curriculum_management/edit_curriculum/{curriculum_id}','RegistrarCollege\CurriculumManagement\CurriculumController@view_course_curriculum');
Route::post('/registrar_college/curriculum_management/edit_curriculum/update/{curriculum_id}','RegistrarCollege\CurriculumManagement\CurriculumController@update_course_curriculum');
Route::post('/registrar_college/curriculum_management/upload/save_changes','RegistrarCollege\CurriculumManagement\UploadCurriculumController@save_changes');

//reports
Route::get('/admin/instructor/instructor_reports','Reports\InstructorReportsController@view_add');
Route::get('/admin/instructor/view_instructor_account/{id}','Users\Instructor\ViewInstructorsController@view_info');

//edit faculty reports
Route::get('/registrar_college/curriculum_management/edit_faculty_loading/{idno}/{type_of_period}', 'RegistrarCollege\CurriculumManagement\FacultyLoadingController@edit_faculty_loading');
Route::get('/admin/instructor/edit_faculty_loading', 'RegistrarCollege\CurriculumManagement\FacultyLoadingController@edit_faculty_loading');
Route::get('/admin/instructor/edit_faculty_loading/{id}','Admin\FacultyLoadingController@instructorlist_reports');

//add new user

//ajax
Route::get('/admin/curriculum_management/ajax/edityear', 'Users\Instructor\ViewInstructorsController@edityear');
Route::get('/admin/curriculum_management/ajax/updateyear', 'Users\Instructor\ViewInstructorsController@updateyear');
Route::get('/admin/curriculum_management/ajax/refreshcurriculum', 'Users\Instructor\ViewInstructorsController@refreshcurriculum');
//example
Route::get('/registrar_college/instructor/view_instructor', 'RegistrarCollege\Instructor\ViewInstructorsController@index');
Route::get('/registrar_college/instructor/add_instructor', 'RegistrarCollege\Instructor\ViewInstructorsController@view_add');
Route::post('/registrar_college/instructor/add_new_instructor', 'RegistrarCollege\Instructor\ViewInstructorsController@add');
Route::get('/registrar_college/instructor/modify_instructor/{idno}', 'RegistrarCollege\Instructor\ViewInstructorsController@view_modify');
Route::post('/registrar_college/instructor/modify_old_instructor', 'RegistrarCollege\Instructor\ViewInstructorsController@modify');
