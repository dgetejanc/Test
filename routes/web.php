<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/profile', 'UserController@profile');

Route::post('/profile', 'UserController@updatePicture');
Route::put('/profile/update', 'UserController@updateData');

//Route is guarded by admin middleware. The middleware checks to see if the user is an admin.
Route::get('/users', ['middleware' => 'admin', 'UserController@getUserList']);
