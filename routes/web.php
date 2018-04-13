<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('admin.module.index.index');
});
Route::get('/employees', function () {
    return view('admin.module.employees.employees');
});
Route::get('/dashboard', [
    'as'=>'dashboard-user',
    'uses'=>'User\DashboardController@index',
    'middleware'=> 'user'
]);

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/login', 'Auth\LoginController@getLogin')->name('login');

Route::post('/login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login',
]);

Route::get('/register ', 'Auth\RegisterController@getRegister')->name('getRegister  ');

Route::post('/register', [
    'as' => 'register-user',
    'uses' => 'Auth\RegisterController@register',
]);

