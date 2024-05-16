<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'ums'], function () {

    Route::get('/bvn_verifications/send_mail/{id}', 'BVNVerification@send_mail')->name('ums.bvn_verifications.send_mail');
    Route::post('/bvn_verifications/reject/{id}', 'BVNVerification@reject')->name('ums.bvn_verifications.reject');
    Route::get('/bvn_verifications/user/{id}', 'BVNVerification@display')->name('ums.bvn_verifications.user');
    Route::get('/departments/initials', 'DepartmentController@initials')->name('ums.departments.initials');
    Route::post('/details', 'UserController@details')->name('user.details');
    Route::get('/kyc_items', 'UserController@kyc')->name('ums.kyc');
    Route::post('/kyc_store', 'UserController@kyc_store')->name('ums.kyc_store');
    Route::get('/nin_verifications/send_mail/{id}', 'NINVerification@send_mail')->name('ums.nin_verifications.send_mail');
    Route::put('/nin_verifications/reject/{id}', 'NINVerification@reject')->name('ums.nin_verifications.reject');
    Route::get('/nin_verifications/user/{id}', 'NINVerification@display')->name('ums.nin_verifications.user');
    Route::post('/password', 'UserController@password')->name('profile.password');
    Route::get('/profile/states/{id}', 'ProfileController@states')->name('profile.states');
    Route::get('/roles/initials', 'RoleController@initials')->name('roles.initials');
    Route::get('/staffs/full_list', 'StaffController@full_list')->name('staffs.full_list');
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::post('/users/roles', 'UserController@roles')->name('users.roles');
    Route::get('/users/search', 'UserController@search')->name('users.search');

    Route::apiResources([
        '/addresses'                => 'CustomerAddressController',
        '/address_verifications'    => 'AddressVerificationController',
        '/bvn_verifications'        => 'BVNVerificationController',
        '/branches'                 => 'BranchController',
        '/bios'                     => 'BioController',
        '/customers'                => 'CustomerController',
        '/departments'              => 'DepartmentController',
        '/nin_verifications'        => 'NINVerificationController',
        '/nok'                      => 'NOKController',
        '/profile'                  => 'ProfileController',
        '/roles'                    => 'RoleController',
        '/socials'                  => 'SocialController',
        '/staffs'                   => 'StaffController',
        '/users'                    => 'UserController',
        '/user_kyc'                 => 'KYCController',
    ]);
});