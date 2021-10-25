<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});

Route::get('/admin/signin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/signin', 'Auth\AdminLoginController@login')->name('admin.login.submit');
// Route::get('/sch/manage', function () {return view('study'); });
Route::get('/init', function() {
    $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('config:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/dashboard', 'AdminController@index')->name('dashboard');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/a/{path}',"AdminController@index")->where( 'path', '([A-z\d\/_.]+)?');
    
Auth::routes();   
Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d\/_.]+)?');
