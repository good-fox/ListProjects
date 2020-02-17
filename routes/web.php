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

use Illuminate\Http\Request;

Route::get('/', function () {
        return view('welcome');
});


Auth::routes();

// Site routes
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@add')->name('home');
Route::delete('/home/del/{project}', 'HomeController@delete')->name('home');
Route::patch('/home/edit/{project}','HomeController@edit')->name('home');


Route::get('/project/{project_id}', 'ProjectController@index')->name('home');
Route::post('/project/{project_id}', 'ProjectController@add')->name('home');
Route::delete('/project/del/{task}', 'ProjectController@delete')->name('home');
Route::patch('/project/edit/{task}','ProjectController@edit')->name('home');


Route::get('/task/{task_id}', 'TaskController@index')->name('home');
Route::patch('/task/status/{task}', 'TaskController@status')->name('home');
Route::patch('/task/content/{task}', 'TaskController@content')->name('home');
Route::post('/task/file/{task}', 'TaskController@file')->name('home');
Route::get('/task/download/{task}', 'TaskController@download')->name('home');


// Admin routes
//Route::group(['prefix' => 'admin'], function() {
//    Route::get('login', 'LoginController@index');
//    Route::post('login', 'LoginController@login')->name('admin.login');
//
//    Route::group(['middleware' => 'admin'], function() {
//        Route::get('/home', 'HomeController@admin')->name('admin.dashboard');
//    });
//});
