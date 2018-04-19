<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/index', function () {
    return view('admin.module.index.index');
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

Route::get('/setupsearch', [
    'as'=>'setupsearch',
    'middleware' => 'user',
    'uses'=>'User\Employee\SearchController@setupsearch',
    ]);

Route::get('/search-process', [
    'as'=>'search-process',
    'middleware' => 'user',
    'uses'=>'User\Employee\SearchController@search']);

Route::post('logout', [
    'as' => 'logout',
    'Auth\LogoutController@postLogout']);

Route::get('/employee/add',['as' => 'getEmployeeAdd', 'uses' => 'Admin\EmployeeController@getEmployeeAdd']);
Route::post('/employee/add',['as' => 'postEmployeeAdd', 'uses' => 'Admin\EmployeeController@postEmployeeAdd']);
Route::get('/employee/edit/{id}',['as' => 'getEmployeeEdit', 'uses' => 'Admin\EmployeeController@getEmployeeEdit']);
Route::post('/employee/edit/{id}',['as' => 'postEmployeeEdit', 'uses' => 'Admin\EmployeeController@postEmployeeEdit']);

/*begin route list employee by Quy*/
Route::resource('employee','User\Employee\EmployeeController');

Route::get('/search ', 'User\Employee\EmployeeController@searchCommonInList')->name('search');

/*the end route list employee by Quy*/
