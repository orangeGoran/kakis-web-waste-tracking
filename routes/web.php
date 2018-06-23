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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
  return "Hello world!";
});

// Route::get('home/admin', 'UserController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home/users', 'AdminController@index')->name('admin');
Route::get('/home/work', 'WorkerController@index')->name('worker');
Route::delete('/home/users/delete', 'AdminController@delete');
Route::post('/home/users/changeType', 'AdminController@changeType');

Auth::routes();
