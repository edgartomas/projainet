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
// Rota pagina inicial (Acessivel a todos)
Route::get('/', 'WelcomeController@index');

//Rota lista de todos os users (Acessivel Admins)
Route::get('/users', 'UserController@index')->name('users.index');

//Rota promove users a admins (Acessivel a Admins)
Route::patch('/users/{user}/promote', 'UserController@promote');

//Rota despromove users a admins (Acessivel a Admins)
Route::patch('/users/{user}/demote', 'UserController@demote');

//Rota bloqueia users (Acessivel a Admins)
Route::patch('/users/{user}/block', 'UserController@block');

//Rota desbloqueia user (Acessivel a Admins)
Route::patch('/users/{user}/unblock', 'UserController@unblock');

//Rota mostra perfil utilizador (Acessivel a logados)
Route::get('/me', 'MyProfileController@index');

//Rota actualiza perfil utilizador (Acessivel a logados)
Route::put('/me/profile', 'MyProfileController@update');

//Rota actualiza password utilizador (Acessivel a logados)
Route::patch('/me/password', 'MyProfileController@updatePassword');

//Rota mostra a lista de user a (Acessivel a logados)
Route::get('/profiles', 'ProfileController@index');

//Rota mostra lista de associados a um user (Acessivel a logados)
Route::get('me/associates', 'AssociatesController@index');

//Rota mostra lista a que um user está associado (Acessivel a logados)
Route::get('me/associate-of', 'AssociateOfController@index');

//Rota associa um user ao user logado (Acessievl a logados)
Route::post('me/associates', 'AssociatesController@create');

//Rota desassocia um user ao user logado (Acessievl a logados)
Route::delete('me/associates/{user}', 'AssociatesController@destroy');

//Rota dashboard do user (Acessivel a logados)
Route::get('/home', 'AccountController@index')->name('home');

Route::get('/accounts/{user}', 'AccountController@all');

Route::get('/accounts/{user}/opened', 'AccountController@opened');

Route::get('/accounts/{user}/closed', 'AccountController@closed');

Route::patch('/account/{account}/close', 'AccountController@close');

Route::patch('/account/{account}/reopen', 'AccountController@reopen');


//Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');
Route::get('/home/{movement}/movement', 'MovementController@indexMovements');


Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');



Route::get('/home/{account}/edit', 'AccountController@edit')->name('accounts.edit');

Route::put('/home/{user}/edit', 'AccountController@update')->name('accounts.update');

Auth::routes();


