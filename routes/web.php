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
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect()->route('login');
});


// AUTENTICAÇÃO
Route::get('/login', 'Auth\LoginController@show')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/authenticate', 'Auth\LoginController@authenticate')->name('authenticate');

// USUÁRIOS

Route::get('/home', 'UserController@index')->name('home');
Route::get('/perfil', 'UserController@perfil')->name('perfil');
Route::post('/editar-perfil', 'UserController@update')->name('editar-perfil');

// ATIVIDADES

Route::get('/atividades', 'ActivityController@index')->name('atividades');
Route::post('/cadastrar-atividade', 'ActivityController@create')->name('cadastrar-atividade');

// Avisos

Route::post('/cadastrar-aviso', 'NoticeController@create')->name('cadastrar-aviso');
Route::get('/close-notice/{id}', 'NoticeController@destroy')->name('close-notice');