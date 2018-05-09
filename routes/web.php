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

Route::get('/', 'WelcomeController@index');


Route::get('/users', 'UserController@index')->name('users.index');

Route::get('/users/{user}/promote', 'UserController@promote');

Route::get('/users/{user}/demote', 'UserController@demote');

Route::get('/users/{user}/block', 'UserController@block');

Route::get('/users/{user}/unblock', 'UserController@unblock');


Route::get('/home', 'AccountController@index')->name('home');


Auth::routes();


