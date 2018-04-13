<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return view('admin.module.index.dashboard');
});

<<<<<<< HEAD
Route::get('/index', function () {
    return view('admin.module.index.index');
});
Route::get('/index3', function () {
    return view('admin.module.index.index3');
});
Route::get('/chartjs', function () {
    return view('admin.module.pages.charts.chartjs');
});

Route::get('login', 'LoginController@getLogin')->name('getLogin');

=======

Route::get('/index', function () {
    return view('admin.module.index.index');
});
Route::get('/employees', function () {
    return view('admin.module.employees.employees');
});
>>>>>>> f6c1705755d820741a6617d4bb95356d29bfe2b5

//Route::group(['prefix' => '/admin','middleware' => 'admin'], function () {
//    Route::resource('/dashboard', 'Admin\DashboardController', [
//        'only' => ['index'],
//    ]);
//});

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


<<<<<<< HEAD
=======

>>>>>>> f6c1705755d820741a6617d4bb95356d29bfe2b5
