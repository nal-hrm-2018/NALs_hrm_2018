<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProcessAddRequest;
Route::get('/index', function () {
    return view('admin.module.index.index');
});

Route::post('logout', [
    'as' => 'logout',
    'Auth\LogoutController@postLogout']);

//cong list route cam pha'

Route::post('/cong_test', [
        'uses' => function (\Illuminate\Http\Request $request) {
            $validator = Validator::make($request->all(),(new ProcessAddRequest())->rules());

            if ($validator->fails()) {
                return response()->json($validator->messages());
            }
            return response()->json(['success' => 'Record is successfully added']);
        },
        'as' => 'cong_test'
    ]

);

Route::get('/cong_test', [
        'uses' => function () {
            return view('projects.test_project_form');
        },
        'as' => 'cong_test_get'
    ]

);

Route::get('/login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@getLogin'
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

Route::group(['prefix' => 'employee', 'middleware' => 'user'], function () {


});

Route::group(['middleware' => 'user'], function () {

    Route::get('/', [
        'as' => 'welcome',
        'uses' => 'User\DashboardController@index',
    ]);

    Route::get('/dashboard', [
        'as' => 'dashboard-user',
        'uses' => 'User\DashboardController@index',
    ]);
    Route::post('employee/postFile', 'User\Employee\EmployeeController@postFile')->name('postFile');
    Route::get('employee/importEmployee', 'User\Employee\EmployeeController@importEmployee')->name('importEmployee');
    Route::post('employee/edit-password', 'User\Employee\EmployeeController@editPass')->name('editPass');
    Route::resource('employee', 'User\Employee\EmployeeController');
    Route::post('/employee/{id}', [
        'as' => 'show_chart',
        'uses' => 'User\Employee\EmployeeController@showChart',
    ]);

    Route::get('/export', 'User\Employee\EmployeeController@export')->name('export');


    Route::resource('teams', 'Team\TeamController');
    Route::get('checkTeamNameEdit', 'Team\TeamController@checkNameTeam');
    Route::post('teams/chart', 'Team\TeamController@showChart');

    Route::post('vendors/postFile', 'User\Vendor\VendorController@postFile')->name('postFile');
    Route::get('vendors/importVendor', 'User\Vendor\VendorController@importVendor')->name('importVendor');
    Route::get('/vendors/export', 'User\Vendor\VendorController@export')->name('vendor-export');
    Route::post('vendors/edit-password', 'User\Vendor\VendorController@editPass')->name('editPass');
    Route::resource('vendors','User\Vendor\VendorController');
    Route::resource('projects','Project\ProjectController');

    Route::post('/vendors/{id}', [
        'as' => 'vendor_show_chart',
        'uses' => 'User\Vendor\VendorController@showChart',
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
Route::get('/quy-test', function () {
    return view('teams.test.quy_test');
});

Route::get('/download-template', 'User\Employee\EmployeeController@downloadTemplate');
Route::get('/download-template-vendor', 'User\Vendor\VendorController@downloadTemplateVendor')->name('vendor-template');
/*the end route list employee by Quy*/

//Route::DELETE('employee/{id} ', 'User\Employee\EmployeeController@destroy')->name('remove');

