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

Route::prefix('users')->group(function(){
    //Rota lista de todos os users (Acessivel Admins)
    Route::get('/', 'UserController@index')->name('users.index');

    Route::prefix('{user}')->group(function(){
        //Rota promove users a admins (Acessivel a Admins)
        Route::patch('/promote', 'UserController@promote')->name('user.promote');

        //Rota despromove users a admins (Acessivel a Admins)
        Route::patch('/demote', 'UserController@demote')->name('user.demote');

        //Rota bloqueia users (Acessivel a Admins)
        Route::patch('/block', 'UserController@block')->name('user.block');

        //Rota desbloqueia user (Acessivel a Admins)
        Route::patch('/unblock', 'UserController@unblock')->name('user.unblock');
    });
});

Route::prefix('me')->group(function(){

    //Rota actualiza password utilizador (Acessivel a logados)
    Route::patch('/password', 'UserController@updatePassword')->name('password.update');

    //Rota mostra perfil utilizador (Acessivel a logados)
    Route::get('/profile', 'UserController@edit')->name('profile.index');

    //Rota actualiza perfil utilizador (Acessivel a logados)
    Route::put('/profile', 'UserController@update')->name('profile.update');

    Route::prefix('associates')->group(function(){
        //Rota mostra lista de associados a um user (Acessivel a logados)
        Route::get('/', 'AssociatesController@index')->name('users.associates');
        //Rota associa um user ao user logado (Acessievl a logados)
        Route::post('/', 'AssociatesController@create')->name('associate.user');
        //Rota desassocia um user ao user logado (Acessievl a logados)
        Route::delete('{user}', 'AssociatesController@destroy')->name('desassociate.user');
    });

    //Rota mostra lista a que um user está associado (Acessivel a logados)
    Route::get('associate-of', 'AssociateOfController@index')->name('users.associatesOf');
});

//Rota mostra a lista de user a (Acessivel a logados)
Route::get('/profiles', 'ProfileController@index')->name('users.profiles');

Route::prefix('accounts/{user}')->group(function(){
    Route::get('/', 'AccountController@all')->name('accounts.index');

    Route::get('/opened', 'AccountController@opened')->name('accounts.opened');

    Route::get('/closed', 'AccountController@closed')->name('accounts.closed');
});

Route::prefix('account')->group(function(){
    //Rota vista criação conta
    Route::get('/', 'AccountController@create')->name('account.create');

    //Rota criar conta
    Route::post('/', 'AccountController@store')->name('account.store');

    Route::prefix('{account}')->group(function(){
        //Rota mostrar vista edição
        Route::get('/', 'AccountController@edit')->name('accounts.edit');

        //Rota edição conta
        Route::put('/', 'AccountController@update')->name('accounts.update');
        
        //Rota remover conta
        Route::delete('/', 'AccountController@destroy')->name('accounts.destroy');

        Route::patch('/close', 'AccountController@close')->name('accounts.close');

        Route::patch('/reopen', 'AccountController@reopen')->name('accounts.reopen');
    });
});

Route::prefix('movements/{account}')->group(function(){
    Route::get('/', 'MovementController@indexMovements')->name('movements.list');

});

Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');







//Route::get('/', 'MovementController@index')->name('movements.index');
//Route::put('/home/{user}/edit', 'AccountController@update')->name('accounts.update');
//Route::get('/home/{user}/account', 'AccountController@UserAccount')->name('home.user');

//Rota dashboard do user (Acessivel a logados)
Route::get('/dashboard', 'AccountController@index')->name('home');

Auth::routes();


