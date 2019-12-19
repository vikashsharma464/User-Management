<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Employee Managements
    Route::post('employee-managements/media', 'EmployeeManagementApiController@storeMedia')->name('employee-managements.storeMedia');
    Route::apiResource('employee-managements', 'EmployeeManagementApiController');
});
