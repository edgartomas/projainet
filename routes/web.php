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

Route::patch('/users/{user}/promote', 'UserController@promote');

Route::patch('/users/{user}/demote', 'UserController@demote');

Route::patch('/users/{user}/block', 'UserController@block');

Route::patch('/users/{user}/unblock', 'UserController@unblock');

Route::get('/profiles', 'ProfileController@index');

Route::get('me/associates', 'AssociatesController@index');

Route::get('me/associate-of', 'AssociateOfController@index');

Route::get('/home', 'AccountController@index')->name('home');
Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');


Auth::routes();


