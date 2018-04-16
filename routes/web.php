<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/index', function () {
    return view('admin.module.index.index');
});
Route::get('/employees', function () {
    return view('admin.module.employees.employees');
});

Route::get('/dashboard', [
    'as' => 'dashboard-user',
    'uses' => 'User\DashboardController@index',
    'middleware' => 'user'
]);

Route::get('/', [
    'as'=> 'welcome',
    'uses' => 'User\DashboardController@index',
    'middleware' => 'user'
]);

Route::get('/login', [
    'as'=> 'login',
    'uses'=>'Auth\LoginController@getLogin'
]);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::post('/login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login',
]);

Route::get('/register ', 'Auth\RegisterController@getRegister')->name('getRegister');

Route::post('/register', [
    'as' => 'register-user',
    'uses' => 'Auth\RegisterController@register',
]);