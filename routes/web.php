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

Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@login');
Route::post('/login-post', 'LoginController@loginp');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});


Route::group(['middleware' => ['isAdmin']], function () {
    Route::post('/signup', 'LoginController@signup');
});
Route::get('/logout','LoginController@logout');

Route::group(['middleware' => ['isLogin']], function () {
    Route::prefix('siswa')->group(function(){
        Route::get('/', 'SiswaController@index');
        Route::get('/{kelas}', 'SiswaController@kelas');
        Route::group(['middleware' => ['isAdmin']], function () {
            Route::post('create-post','SiswaController@createp');
            Route::get('/{id}/edit', 'SiswaController@edit');
            Route::post('/{id}/edit-post','SiswaController@editp');
            Route::get('/{id}/delete', 'SiswaController@delete');
        });
    });

    Route::prefix('guru')->group(function(){
        Route::get('/','GuruController@index');
        Route::group(['middleware' => ['isAdmin']], function () {
            Route::post('/create-post', 'GuruController@createp');
            Route::get('/{id}/edit', 'GuruController@edit');
            Route::post('/{id}/edit-post', 'GuruController@editp');
            Route::get('/{id}/delete', 'GuruController@delete');
        });
    });

    Route::prefix('jurnal')->group(function(){
        // Route::get('/{id}/edit', 'JurnalController@edit');
        Route::post('/{id}/edit-post', 'JurnalController@editp');
        Route::group(['middleware' => ['isExist']], function () {
            Route::post('/create-post', 'JurnalController@createp');
            Route::group(['middleware' => ['isGuru']], function () {
                Route::post('/create-2', 'JurnalController@create2');
                Route::get('/create', 'JurnalController@create');
            });
        });
        Route::group(['middleware' => ['isKetua']], function () {
            Route::get('/{id}/accept', 'JurnalController@acc');
        });
        Route::group(['middleware' => ['isGuru']], function () {
            Route::get('/{id}/add-absen', 'JurnalController@add');
            Route::get('/{id}/edit', 'JurnalController@edit');
            Route::post('/{id}/edit-2', 'JurnalController@edit2');
            Route::post('/{id}/add-absen-post', 'JurnalController@addp');
            Route::get('/{id}/delete', 'JurnalController@delete');
        });
        Route::get('/', 'JurnalController@index');
        Route::get('/{id}/info', 'JurnalController@info');
        Route::get('/bulanan', 'JurnalController@bulanan');
        Route::group(['middleware' => ['isAdmin']], function () {
            Route::post('/print', 'JurnalController@print');
            Route::get('/kelas/{id}', 'JurnalController@kelas');
        });
    });

    Route::prefix('profile')->group(function()
    {
        Route::get('/','ProfileController@index');
        Route::post('/change-password','ProfileController@change');
        Route::group(['middleware' => 'isAdmin'], function () {
            Route::post('/set-jam', 'ProfileController@setjam');
        });
    });
});
