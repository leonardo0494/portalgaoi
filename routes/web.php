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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(!Auth::check()){
        return redirect()->route('login');
    } else {
        return redirect()->route('inicial');
    }
});

Route::get('/home', function () {
    if(!Auth::check()){
        return redirect()->route('login');
    } else {
        return redirect()->route('inicial');
    }
})->name('home');

// AUTENTICAÇÃO
Route::get('/login', 'Auth\LoginController@show')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/authenticate', 'Auth\LoginController@authenticate')->name('authenticate');

Route::group(['middleware' => ['auth']], function () {

    // USUÁRIOS
    Route::get('/inicial', 'UserController@index')->name('inicial');
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
    Route::get('/save-reports', 'ReportsController@saveReportsScreen')->name('save-reports');
    Route::get('/list-reports', 'ReportsController@listReports')->name('list-reports');
    Route::get('/atividade-online', 'ReportsController@exposeBusyResource')->name('atividade-online');
    Route::get('/check-atividade', 'ReportsController@checkReport')->name('check-atividade');
    Route::get('/detalhe-atividade', 'ReportsController@detailsReports')->name('detalhes-atividade');
    
    Route::post('/save-reports', 'ReportsController@saveReports')->name('save-reports');
    Route::post('/atividade-finalizada', 'ReportsController@completeBusyResourceActivity')->name('atividade-finalizada');

});
