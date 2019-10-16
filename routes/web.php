<?php

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


Route::get('/tasks', function () {
    return view('task');
});
Route::get('/add_sec', function () {
    return view('add_section');
});
Route::get('/add_emp','EmployeeController@addNewEmployee');
Route::post('/sendemail','MailController@basic_email');

Route::post('/saveTasks','TaskController@store');
Route::get('/demo', function () {
    return view('demo');
 });
 Route::get('/add', 'EmployeeController@index');

 Route::get('/view_ongoing','TaskController@ongoingTask');
 Route::get('/view_pending','TaskController@pendingTask');
 Route::get('/view_completed','TaskController@completedTask');

 
 Route::get('/getEmployees/{id}', 'EmployeeController@getEmployees');
 Route::get('/getAllEmployees', 'EmployeeController@getAllEmployees');

 Route::post('/getReminders','TaskController@getReminders');
 Route::post('/addReminders','TaskController@addReminders');
 Route::post('/taskCompleted','TaskController@taskCompleted');

 Route::post('/delTask','TaskController@deleteTask'); 
 Route::post('/updateTask','TaskController@updateTask');
 Route::get('/getSections', 'EmployeeController@getSections');
 Route::post('/addemployee', 'EmployeeController@addemployee');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/addsection', 'EmployeeController@addSection');
