<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('signup', 'AuthController@signup');
    Route::get('logout', 'AuthController@logout');
    Route::get('current-user', 'AuthController@currentUser');
    Route::patch('update-role-user/{id}', 'UserController@updateRole');
    Route::resource('/workspaces', 'WorkspaceController');
    Route::resource('/teams', 'TeamController');
    Route::resource('/types', 'TypeController');
    Route::resource('/batches', 'BatchController');
    Route::resource('/subjects', 'SubjectController');
    Route::resource('/reviews', 'ReviewController');
    Route::resource('/reports', 'ReportController');
    Route::resource('/trainees', 'TraineeController');
    Route::resource('/schedules', 'ScheduleController');
    Route::put('/schedules', 'ScheduleController@update');
    Route::resource('/roles', 'RoleController');
});
