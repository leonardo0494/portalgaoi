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
Route::get('/usuarios', 'UserController@list')->name('usuarios');
Route::post('/editar-perfil', 'UserController@update')->name('editar-perfil');

// ATIVIDADES

Route::get('/atividades', 'ActivityController@index')->name('atividades');
Route::post('/cadastrar-atividade', 'ActivityController@create')->name('cadastrar-atividade');
Route::get('/searchById', 'ActivityController@searchById')->name('searchById');
Route::get('/atualizar-atividade', 'ActivityController@update')->name('atualizar-atividade');

// Avisos

Route::post('/cadastrar-aviso', 'NoticeController@create')->name('cadastrar-aviso');
Route::get('/close-notice/{id}', 'NoticeController@destroy')->name('close-notice');

// Calendário

Route::get('/calendario', 'TeamScheduleController@index')->name('calendario');

// REPORTS

Route::post('/save-reports', 'ReportsController@saveReports')->name('save-reports');
Route::get('/list-reports', 'ReportsController@listReports')->name('list-reports');

Route::get('/atividade-online', 'ReportsController@exposeBusyResource')->name('atividade-online');
Route::get('/atividade-finalizada', 'ReportsController@deleteBusyResourceActivity')->name('atividade-finalizada');