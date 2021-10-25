<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/admin/signup', 'Auth\AdminLoginController@signup');
Route::post('/newstudent/medical', 'StudentsController@medical');
Route::post('/newstudent/highlevel', 'StudentsController@highlevel');
Route::get('/newstudent/reviews', 'StudentsController@studentReview');
Route::get('/newstudent/fees', 'StudentsController@fees');

Route::get('/session/current', 'Management\SchoolSessionController@currentSession');
Route::get('/dashboard/admin', 'Management\ConfigsController@adminDashboard');

Route::post('/curriculum/registration', 'Student\TimetableController@courseRegistration');

Route::apiResources([
    'students' => 'StudentsController',
    'scholars' => 'Student\ScholarController',
    'lecturers' => 'Management\LecturerController',
    'configs' => 'Management\ConfigsController',

    'managers' => 'Management\ManagersController',
    'paylists' => 'Management\PaymentListController',
    'schooldegree' => 'Management\SchoolDegreeController',
    'schooldepartment' => 'Management\SchoolDepartmentController',
    
    'timetable' => 'Student\TimetableController',
    'curriculum' => 'Management\CourseCurriculumController',
    'schoolsessions' => 'Management\SchoolSessionController',
    'sessionevents' => 'Management\SessionEventsController',
    'schoolsemester' => 'Management\SchoolSemesterController',
    'coursestudy' => 'Management\CourseStudyController',

    'schoolscreaning' => 'Management\SchoolScreaningController'
]);  