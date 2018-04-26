<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/index', function () {
    return view('admin.module.index.index');
});

Route::post('logout', [
    'as' => 'logout',
    'Auth\LogoutController@postLogout']);

//cong list route cam pha'

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

Route::group(['prefix'=>'employee','middleware'=>'user'],function (){

    Route::get('/search-process', [
        'as'=>'search-process',
        'uses'=>'User\Employee\SearchController@search']);

});

Route::group(['middleware'=>'user'],function (){

    Route::get('/', [
        'as'=> 'welcome',
        'uses' => 'User\DashboardController@index',
    ]);

    Route::get('/dashboard', [
        'as' => 'dashboard-user',
        'uses' => 'User\DashboardController@index',
    ]);

});

//cong list route cam pha'

Route::post('logout', [
    'as' => 'logout',
    'Auth\LogoutController@postLogout']);

/*Route::get('/employee/add',['as' => 'getEmployeeAdd', 'uses' => 'Admin\EmployeeController@getEmployeeAdd']);
Route::post('/employee/add',['as' => 'postEmployeeAdd', 'uses' => 'Admin\EmployeeController@postEmployeeAdd']);
Route::get('/employee/edit/{id}',['as' => 'getEmployeeEdit', 'uses' => 'Admin\EmployeeController@getEmployeeEdit']);
Route::post('/employee/edit/{id}',['as' => 'postEmployeeEdit', 'uses' => 'Admin\EmployeeController@postEmployeeEdit']); */

/*begin route list employee by Quy*/
Route::post('employee/postFile', 'User\Employee\EmployeeController@postFile')->name('postFile');
/*Route::get('employee/listEmployeeImport', 'User\Employee\EmployeeController@listEmployeeImport');*/
Route::get('employee/importEmployee', 'User\Employee\EmployeeController@importEmployee')->name('importEmployee');
Route::resource('employee','User\Employee\EmployeeController');

Route::get('/export ', 'User\Employee\EmployeeController@export')->name('export');



/*the end route list employee by Quy*/
