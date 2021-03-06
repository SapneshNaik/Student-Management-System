<?php


use App\Constants;


Route::group([
    'prefix' => 'v1',
], function () {
    //Non Auth routes
    Route::post('login', 'Auth\AuthController@login')
        ->name('login')->middleware('can_login');


    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        //only authenticated users can register admin/staff/students,
        Route::post('register', 'Auth\AuthController@register')
            ->name('register')
            ->middleware('permission:'
                . Constants::PERMISSIONS['REGISTER_STAFF'] . '|'
                . Constants::PERMISSIONS['REGISTER_STUDENT'] . '|'
                . Constants::PERMISSIONS['REGISTER_PARENT'] . '|'
                . Constants::PERMISSIONS['REGISTER_ADMIN'] . '');

        Route::get('logout', 'Auth\AuthController@logout')->name('logout');

        //TODO: BugFix: wired behaviour in PostMan when you try access this endpoint with wrong Token (405 Not Allowed)
        Route::get('/permissions', '\App\Http\Controllers\Auth\AuthController@permissionsIndex')
            ->name('permissions.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_PERMISSIONS'].'');

        //TODO: BugFix: wired behaviour in PostMan when you try access this endpoint with wrong Token (405 Not Allowed)
        Route::get('/roles', '\App\Http\Controllers\Auth\AuthController@rolesIndex')
            ->name('roles.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_ROLES'].'');

        Route::post('/roles', '\App\Http\Controllers\Auth\AuthController@rolesStore')
            ->name('roles.store')
            ->middleware('permission:'.Constants::PERMISSIONS['EDIT_ALL_ROLES'].'');

        Route::get('/roles/{role}', '\App\Http\Controllers\Auth\AuthController@roleShow')
            ->name('roles.show')
            ->middleware('permission:' . Constants::PERMISSIONS['VIEW_SPECIFIC_ROLE'] . '');

        Route::put('/roles/{role}', '\App\Http\Controllers\Auth\AuthController@rolesUpdate')
            ->name('roles.update')
            ->middleware('permission:'.Constants::PERMISSIONS['EDIT_ALL_ROLES'].'');

        Route::delete('/roles/{role}', '\App\Http\Controllers\Auth\AuthController@rolesDelete')
            ->name('roles.delete')
            ->middleware('permission:'.Constants::PERMISSIONS['DELETE_ALL_ROLES'].'');

        Route::post('/roles/{role}/addUser/{user}', '\App\Http\Controllers\Auth\AuthController@rolesAddUser')
            ->name('roles.addUser')
            ->middleware('permission:'
                . Constants::PERMISSIONS['REGISTER_STAFF'] . '|'
                . Constants::PERMISSIONS['REGISTER_ADMIN'] . '');

        //TODO: Give priority to Base Role 1 Admin, 2 Staff, 3 Student, 4 Parent
        // Make sure even though a user has permission to edit higher role type it is not allowed by the system
        Route::post('/roles/{role}/removeUser/{user}', '\App\Http\Controllers\Auth\AuthController@rolesRemoveUser')
            ->name('roles.removeUser')
            ->middleware('permission:'
                . Constants::PERMISSIONS['EDIT_ALL_STAFF'] . '|'
                . Constants::PERMISSIONS['EDIT_ALL_ADMINS'] . '');


        Route::get('/user', '\App\Http\Controllers\UserController@profile')
            ->name('user.profile');

        Route::get('/users', '\App\Http\Controllers\UserController@index')
            ->name('users.index')
            ->middleware('permission:' . Constants::PERMISSIONS['VIEW_ALL_USERS'] . '');

        Route::get('/users/{user}', '\App\Http\Controllers\UserController@show')
            ->name('users.show')
            ->middleware('permission:' . Constants::PERMISSIONS['VIEW_SPECIFIC_USER'] . '');

        //DONE: Add check for own profile or edit all user perm in controller [DONE]
        Route::put('/users/{user}', '\App\Http\Controllers\UserController@update')
            ->name('users.update');

        Route::delete('/users/{user}', '\App\Http\Controllers\UserController@delete')
            ->name('users.delete')
            ->middleware('permission:' . Constants::PERMISSIONS['DELETE_ALL_USERS'] . '');


        //Student Routes

        Route::get('/student', '\App\Http\Controllers\StudentController@profile')
            ->name('student.profile');

        Route::get('/students', '\App\Http\Controllers\StudentController@index')
            ->name('students.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_STUDENTS'].'');

        Route::post('/students/{user}', '\App\Http\Controllers\StudentController@store')
            ->name('students.store')
            ->middleware('permission:' . Constants::PERMISSIONS['REGISTER_STUDENT'] . '');

        //DONE: Check if /user can also fetch student(role) details from query filter. \n
        // below API can only be used by VIEW_ALL_STUDENTS permission [DONE]
        Route::get('/students/{user}', '\App\Http\Controllers\StudentController@show')
            ->name('students.show')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_SPECIFIC_STUDENT'].'');

        //DONE: Add check for own profile or edit all user perm in controller [DONE]
        Route::put('/students/{user}', '\App\Http\Controllers\StudentController@update')
            ->name('students.update');


        // ==> Address routes
        Route::get('/address', '\App\Http\Controllers\AddressController@profile')
            ->name('address.profile');

        Route::get('/addresses', '\App\Http\Controllers\AddressController@index')
            ->name('addresses.index')
            ->middleware('permission:'
                . Constants::PERMISSIONS['VIEW_ALL_STAFF'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_ADMINS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_PARENTS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_STUDENTS'] . '');

        Route::post('/addresses/{user}', '\App\Http\Controllers\AddressController@store')
            ->name('addresses.store')
            ->middleware('permission:'
                . Constants::PERMISSIONS['REGISTER_STAFF'] . '|'
                . Constants::PERMISSIONS['REGISTER_STUDENT'] . '|'
                . Constants::PERMISSIONS['REGISTER_PARENT'] . '|'
                . Constants::PERMISSIONS['REGISTER_ADMIN'] . '');


        //DONE: Check if /user can also fetch student(role) details from query filter. \n
        // below API can only be used by VIEW_ALL_STUDENTS permission [DONE]
        Route::get('/addresses/{user}', '\App\Http\Controllers\AddressController@show')
            ->name('addresses.show')
            ->middleware('permission:'
                . Constants::PERMISSIONS['VIEW_ALL_STAFF'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_ADMINS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_PARENTS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_STUDENTS'] . '|'
                . Constants::PERMISSIONS['VIEW_SPECIFIC_STAFF'] . '|'
                . Constants::PERMISSIONS['VIEW_SPECIFIC_ADMIN'] . '|'
                . Constants::PERMISSIONS['VIEW_SPECIFIC_PARENT'] . '|'
                . Constants::PERMISSIONS['VIEW_SPECIFIC_STUDENT'] . '');


        //DONE: Add check for own profile or edit all user perm in controller [DONE]
        Route::put('/addresses/{user}', '\App\Http\Controllers\AddressController@update')
            ->name('addresses.update');

        //StudentParent Routes

        Route::get('/parent', '\App\Http\Controllers\StudentParentController@profile')
            ->name('parent.profile');

        Route::get('/parents', '\App\Http\Controllers\StudentParentController@index')
            ->name('parents.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_PARENTS'].'');


        Route::get('/parent-search', '\App\Http\Controllers\StudentParentController@search')
            ->name('parents.search')
            ->middleware('permission:' . Constants::PERMISSIONS['SEARCH_PARENT'] . '');

        Route::post('/parents/{user}', '\App\Http\Controllers\StudentParentController@store')
            ->name('parents.store')
            ->middleware('permission:' . Constants::PERMISSIONS['REGISTER_PARENT'] . '');

        //DONE: Check if /user can also fetch parent(role) details from query filter. \n
        // below API can only be used by VIEW_ALL_STUDENTS permission [DONE]
        Route::get('/parents/{user}', '\App\Http\Controllers\StudentParentController@show')
            ->name('parents.show')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_SPECIFIC_PARENT'].'');

        //DONE: Add check for own profile or edit all parent perm in controller [DONE]
        Route::put('/parents/{user}', '\App\Http\Controllers\StudentParentController@update')
            ->name('parents.update');
//
//        Route::delete('/users/{user}', '\App\Http\Controllers\UserController@delete')
//            ->name('users.delete')
//            ->middleware('permission:' . Constants::PERMISSIONS['DELETE_ALL_USERS'] . '');


        //Admin Routes

        Route::get('/admin', '\App\Http\Controllers\AdminController@profile')
            ->name('admin.profile');

        Route::get('/admins', '\App\Http\Controllers\AdminController@index')
            ->name('admins.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_ADMINS'].'');

        Route::post('/admins/{user}', '\App\Http\Controllers\AdminController@store')
            ->name('admins.store')
            ->middleware('permission:' . Constants::PERMISSIONS['REGISTER_ADMIN'] . '');

        //DONE: Check if /user can also fetch admin(role) details from query filter. \n
        // below API can only be used by VIEW_ALL_STUDENTS permission [DONE]
        Route::get('/admins/{user}', '\App\Http\Controllers\AdminController@show')
            ->name('admins.show')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_SPECIFIC_ADMIN'].'');

        //DONE: Add check for own profile or edit all user perm in controller [DONE]
        Route::put('/admins/{user}', '\App\Http\Controllers\AdminController@update')
            ->name('admins.update');

        Route::get('/sms-stats', '\App\Http\Controllers\AdminController@stats')
            ->name('sms.stats')
            ->middleware('permission:'
                . Constants::PERMISSIONS['VIEW_ALL_STAFF'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_ADMINS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_PARENTS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_USERS'] . '|'
                . Constants::PERMISSIONS['VIEW_ALL_STUDENTS'] . '');
        //Staff Routes

        Route::get('/staff', '\App\Http\Controllers\StaffController@profile')
            ->name('staff.profile');

        Route::get('/staffs', '\App\Http\Controllers\StaffController@index')
            ->name('staffs.index')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_ALL_STAFF'].'');

        Route::post('/staffs/{user}', '\App\Http\Controllers\StaffController@store')
            ->name('staffs.store')
            ->middleware('permission:' . Constants::PERMISSIONS['REGISTER_STAFF'] . '');

        //DONE: Check if /user can also fetch staff(role) details from query filter. \n
        // below API can only be used by VIEW_ALL_STUDENTS permission
        Route::get('/staffs/{user}', '\App\Http\Controllers\StaffController@show')
            ->name('staffs.show')
            ->middleware('permission:'.Constants::PERMISSIONS['VIEW_SPECIFIC_STAFF'].'');

        //DONE: Add check for own profile or edit all user perm in controller [DONE]
        Route::put('/staffs/{user}', '\App\Http\Controllers\StaffController@update')
            ->name('staffs.update');

        Route::get('/staff-search', '\App\Http\Controllers\StaffController@search')
            ->name('staff.search')
            ->middleware('permission:' . Constants::PERMISSIONS['SEARCH_STAFF'] . '');

        //TODO: Permission based un-authorized request can be logged in a logging module with VARIOUS LEVEL
        //TODO: on password update (by himself or others): flush user token

        //permission related routes

        //Staff Routes
    });


});




