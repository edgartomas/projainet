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
Route::get('/', 'WelcomeController@index')->name('index');

//Rota lista de todos os users (Acessivel Admins)
Route::get('/users', 'UserController@index')->name('users.index');

//Rota promove users a admins (Acessivel a Admins)
Route::patch('/users/{user}/promote', 'UserController@promote')->name('user.promote');

//Rota despromove users a admins (Acessivel a Admins)
Route::patch('/users/{user}/demote', 'UserController@demote')->name('user.demote');

//Rota bloqueia users (Acessivel a Admins)
Route::patch('/users/{user}/block', 'UserController@block')->name('user.block');

//Rota desbloqueia user (Acessivel a Admins)
Route::patch('/users/{user}/unblock', 'UserController@unblock')->name('user.unblock');

//Rota mostra perfil utilizador (Acessivel a logados)
Route::get('/me/profile', 'MyProfileController@index')->name('profile.index');

//Rota actualiza perfil utilizador (Acessivel a logados)
Route::put('/me/profile', 'MyProfileController@update')->name('profile.update');

//Rota actualiza password utilizador (Acessivel a logados)
Route::patch('/me/password', 'MyProfileController@updatePassword')->name('password.update');

//Rota mostra a lista de user a (Acessivel a logados)
Route::get('/profiles', 'ProfileController@index')->name('users.profiles');

//Rota mostra lista de associados a um user (Acessivel a logados)
Route::get('me/associates', 'AssociatesController@index')->name('users.associates');

//Rota mostra lista a que um user está associado (Acessivel a logados)
Route::get('me/associate-of', 'AssociateOfController@index')->name('users.associatesOf');

//Rota associa um user ao user logado (Acessievl a logados)
Route::post('me/associates', 'AssociatesController@create')->name('associate.user');

//Rota desassocia um user ao user logado (Acessievl a logados)
Route::delete('me/associates/{user}', 'AssociatesController@destroy')->name('desassociate.user');

//Rota dashboard do user (Acessivel a logados)
Route::get('/home', 'AccountController@index')->name('home');

//Rota vista criação conta
Route::get('/account', 'AccountController@create')->name('account.create');

//Rota criar conta
Route::post('/account', 'AccountController@store')->name('account.store');

Route::get('/accounts/{user}', 'AccountController@all')->name('accounts.index');

Route::get('/accounts/{user}/opened', 'AccountController@opened')->name('accounts.opened');

Route::get('/accounts/{user}/closed', 'AccountController@closed')->name('accounts.closed');

Route::patch('/account/{account}/close', 'AccountController@close')->name('accounts.close');

Route::patch('/account/{account}/reopen', 'AccountController@reopen')->name('accounts.reopen');


//Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');
Route::get('/home/{movement}/movement', 'MovementController@indexMovements')->name('movements.index');


Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');



Route::put('/account/{account}', 'AccountController@update')->name('accounts.update');

Route::get('/account/{account}', 'AccountController@edit')->name('accounts.edit');
//Route::put('/home/{user}/edit', 'AccountController@update')->name('accounts.update');

// 
Route::get('/home/movements/{accounts}', 'MovementController@indexMovements')->name('movements.list');

Auth::routes();


