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
Route::get('/employee/add',['as' => 'getEmployeeAdd', 'uses' => 'Admin\EmployeeController@getEmployeeAdd']);
Route::post('/employee/add',['as' => 'postEmployeeAdd', 'uses' => 'Admin\EmployeeController@postEmployeeAdd']);
/*Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix' => '/', 'namespace' =>'Admin'], function(){
        Route::group(['prefix' => 'employee'],function(){
            Route::get('add',['as' => 'getCatAdd', 'uses' => 'catController@getCatAdd']);
            Route::post('add',['as' => 'postCatAdd', 'uses' => 'catController@postCatAdd']);
            Route::get('list',['as' => 'getCatList', 'uses' => 'catController@getCatList']);
            Route::get('delete/{id}',['as' => 'getCatDelete', 'uses' => 'catController@getCatDelete'])->where('id','[0-9]+');
            Route::get('edit/{id}',['as' => 'getCatEdit', 'uses' => 'catController@getCatEdit'])->where('id','[0-9]+');
            Route::post('edit/{id}',['as' => 'postCatEdit', 'uses' => 'catController@postCatEdit'])->where('id','[0-9]+');
        });
        Route::group(['prefix' => 'employee'],function(){
            Route::get('add',['as' => 'getEmployeeAdd', 'uses' => 'EmployeeController@getEmployeeAdd']);
            Route::post('add',['as' => 'postUserAdd', 'uses' => 'UserController@postUserAdd']);
            Route::get('list',['as' => 'getUserList', 'uses' => 'UserController@getUserList']);
        });
    });
});*/