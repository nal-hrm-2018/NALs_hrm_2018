<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/login', 'API\BaseAPIController@login');
Route::post('auth/register', 'API\BaseAPIController@register');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::apiResources([
        'profile' => 'API\ProfileController',
        'employee' => 'API\ListEmployeeController',
        'project' => 'API\EmployeeProjectController'
    ]);
});
