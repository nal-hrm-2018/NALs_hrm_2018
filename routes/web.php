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

Route::post('testup',function(){
	$file = request()->file('myFile');
	$destinationPath = 'uploads';
    $file->move($destinationPath,$file->getClientOriginalName());
});
//cong list route cam pha'
Route::get('/languages/{locale}', [
    'as'=> 'setlanguaes',
    'uses'=>'LanguageController@index'
]);

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
    Route::post('employee/edit-password/{id}', 'User\Employee\EmployeeController@editPass')->name('editPass');
    Route::resource('employee', 'User\Employee\EmployeeController');

    Route::get('employee',[
        'uses'=> 'User\Employee\EmployeeController@index',
        'as' => 'employee.index'
    ])->middleware('role:view_list_employee');

    Route::get('employee/create',[
        'uses' => 'User\Employee\EmployeeController@create',
        'as' => 'employee.create '
    ])->middleware('role:add_new_employee');

    Route::get('employee/delete/{id}',[
        'uses' => 'User\Employee\EmployeeController@destroy',
        'as' => 'employee.destroy'
    ])->middleware('role:delete_employee');

    Route::get('employee/importEmployee',[
        'uses' => 'User\Employee\EmployeeController@importEmployee' ,
        'as' => 'importEmployee '
    ]);

    // Route::post('employee/store',[
    //     'uses' =>
    // ]);
    Route::post('/employee/{id}', [
        'as' => 'show_chart',
        'uses' => 'User\Employee\EmployeeController@showChart',
    ]);

    Route::get('/employee/{employee}',[
        'as' =>'employee.show',
        'uses' => 'User\Employee\EmployeeController@show'
    ])->middleware('role:view_employee_basic');

    Route::get('employee/{employee}/edit',[
        'as' => 'employee.edit',
        'uses' => 'User\Employee\EmployeeController@edit' 
    ])->middleware('role:edit_profile');

    Route::get('/export', 'User\Employee\EmployeeController@export')->name('export');


    Route::resource('teams', 'Team\TeamController');
    Route::get('checkTeamNameEdit', 'Team\TeamController@checkNameTeam');
    Route::post('teams/chart', 'Team\TeamController@showChart');

    Route::post('vendors/postFile', 'User\Vendor\VendorController@postFile')->name('postFile');
    Route::get('vendors/importVendor', 'User\Vendor\VendorController@importVendor')->name('importVendor');
    Route::get('/vendors/export', 'User\Vendor\VendorController@export')->name('vendor-export');
    Route::post('vendors/edit-password', 'User\Vendor\VendorController@editPass')->name('editPass');
    Route::resource('vendors', 'User\Vendor\VendorController');
    Route::resource('projects', 'Project\ProjectController');

    Route::post('/absences/{id}', [
        'as' => 'show_absence',
        'uses' => 'Absence\AbsenceController@showAbsence',
    ]);
    Route::get('absences/hr',[
        'uses'=>'Absence\AbsenceController@indexHR',
        'as'=>'absences-hr'
    ])->middleware('role:view_employee_absence_history');
    Route::post('absences/hr/export',[
        'uses'=>'Absence\AbsenceController@exportAbsenceHR',
        'as'=>'export-absences-hr'
    ])->middleware('role:view_employee_absence_history');
    Route::get('holiday',[
        'uses'=>'Absence\HolidayController@index',
        'as'=>'absences-holiday'
    ])->middleware('role:view_holiday_list');
    Route::post('/holiday',[
        'uses'=>'Absence\HolidayController@store',
        'as'=>'absences-holiday'
    ]);
    Route::get('holiday/{id}/edit',[
        'uses'=>'Absence\HolidayController@edit',
        'as'=>'absences-holiday-edit'
    ]);
    Route::delete('holiday/{id}',[
        'uses'=>'Absence\HolidayController@destroy',
        'as'=>'absences-holiday-delete'
    ]);
    Route::PUT('holiday',[
        'uses'=>'Absence\HolidayController@update',
        'as'=>'absences-holiday-update'
    ]);
    // Route::get('absence/po-project', 'Absence\AbsenceController@confirmRequest')->name('confirmRequest');
    Route::get('absence/po-project', 'Absence\AbsenceController@showListPO')->name('showListPO');
    Route::get('absences/delete/{id}', [
        'uses' => 'Absence\AbsenceController@destroy',
        'as' => 'absencess.destroy'
    ]);
    Route::post('absence/po-project/{id}', 'Absence\AbsenceController@confirmRequestAjax')->name('confirmRequestAjax');
    Route::get('/export-confirm-list', 'Absence\AbsenceController@exportConfirmList')->name('exportConfirmList');
    Route::resource('absences', 'Absence\AbsenceController');

    Route::get('absences',[
        'uses' => 'Absence\AbsenceController@index',
        'as' => 'absences.index'
    ])->middleware('role:view_absence_history');

    Route::get('absences/create',[
        'uses' => 'Absence\AbsenceController@create',
        'as' => 'absences.create'
    ])->middleware('role:add_new_absence');


    Route::post('/absence', [
        'as' => 'cancel_request',
        'uses' => 'Absence\AbsenceController@cancelRequest',
    ]);

    Route::post('projects/checkProcessAjax',[
        'as'=>'checkProcessAjax',
        'uses'=>'Project\ProjectController@checkProcessesAjax'
    ]);
    Route::post('projects/reopenProjectAjax',[
        'as'=>'reopenProjectAjax',
        'uses'=>'Project\ProjectController@reopenProjectAjax'
    ]);



    Route::post('/vendors/{id}', [
        'as' => 'vendor_show_chart',
        'uses' => 'User\Vendor\VendorController@showChart',
    ]);


    Route::get('/absence-po', 'Absence\AbsenceController@showListAbsence')->name('absence-po');
    Route::post('/deny-po-team', 'Absence\AbsenceController@denyPOTeam');
    Route::post('/done-confirm', 'Absence\AbsenceController@doneConfirm');
    Route::get('ot/po-ot', [
        'as' => 'po-ot',
        'uses' => 'OT\OTController@indexPO',
    ]);
    Route::get('ot/po-ot/{id}', [
        'as' => 'po-ot.accept',
        'uses' => 'OT\OTController@acceptOT',
    ]);
    Route::get('ot/po-ot/reject/{id}', [
        'as' => 'po-ot.reject',
        'uses' => 'OT\OTController@rejectOT',
    ]);
    Route::get('ot/hr-ot', [
        'as' => 'hr-ot',
        'uses' => 'OT\OTController@indexHR',
    ]);
    Route::resource('ot', 'OT\OTController');
       
    Route::resource('notification', 'Notification\NotificationController');
    Route::get('notification/{notification}', [
        'uses' => 'Notification\NotificationController@destroy',
        'as' => 'notification.destroy'
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
Route::get('/phu-test', function (){
    return view('projects.add');
});
Route::get('/download-template', 'User\Employee\EmployeeController@downloadTemplate');
Route::get('/download-template-vendor', 'User\Vendor\VendorController@downloadTemplateVendor')->name('vendor-template');
Route::get('/download-absence-po-team', 'Absence\AbsenceController@exportAbsencePoTeam')->name('absence-po-team');
/*the end route list employee by Quy*/

//Route::DELETE('employee/{id} ', 'User\Employee\EmployeeController@destroy')->name('remove');

