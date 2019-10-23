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
})->name('task');
Route::get('/add_sec', function () {
    return view('add_section');
})->name('add_sec');
Route::get('/add_emp','EmployeeController@addNewEmployee')->name('add_emp');
Route::post('/sendemail','MailController@basic_email')->name('sendemail');

Route::post('/saveTasks','TaskController@store')->name('saveTasks');
Route::get('/demo', function () {
    return view('demo');
 })->name('demo');
 Route::get('/add', 'EmployeeController@index')->name('add');

 Route::get('/view_ongoing','TaskController@ongoingTask')->name('view_ongoing');
 Route::get('/view_pending','TaskController@pendingTask')->name('view_pending');
 Route::get('/view_completed','TaskController@completedTask')->name('view_completed');

 
 Route::get('/getEmployees/{id}', 'EmployeeController@getEmployees')->name('getEmployees');
 Route::get('/getAllEmployees', 'EmployeeController@getAllEmployees')->name('getAllEmployees');

 Route::post('/getReminders','TaskController@getReminders')->name('getReminders');
 Route::post('/addReminders','MailController@addReminders')->name('addReminders');
 Route::post('/taskCompleted','TaskController@taskCompleted')->name('taskCompleted');

 Route::post('/delTask','TaskController@deleteTask')->name('delTask'); 
 Route::post('/updateTask','TaskController@updateTask')->name('updateTask');
 Route::get('/getSections', 'EmployeeController@getSections')->name('getSections');
 Route::post('/addemployee', 'EmployeeController@addemployee')->name('addemployee');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->name('home');
Route::post('/addsection', 'EmployeeController@addSection')->name('addsection');
Route::post('/get_report', 'TaskController@getReport')->name('get_report');
Route::get('/printpdf', [ 'as' => 'customer.printpdf', 'uses' => 'CustomerController@printPDF'])->name('printPDF');
