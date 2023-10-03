<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'ums'], function () {

    Route::get('/bvn_verifications/send_mail/{id}', 'ConfirmationController@send_mail')->name('ums.bvn_verifications.send_mail');
    Route::get('/kyc_items', 'UserController@kyc')->name('ums.kyc');
    Route::post('/kyc_store', 'UserController@kyc_store')->name('ums.kyc_store');
    Route::get('/profile', 'UserController@profile')->name('profile.initials');
    Route::post('/password', 'UserController@password')->name('profile.password');
    Route::post('/details', 'UserController@details')->name('user.details');
    Route::get('/roles/initials', 'RoleController@initials')->name('roles.initials');
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::post('/users/roles', 'UserController@roles')->name('users.roles');
    Route::get('/users/search', 'UserController@search')->name('users.search');

    Route::apiResources([
        '/addresses'    => 'CustomerAddressController',
        '/address_verifications' => 'AddressVerificationController',
        '/bvn_verifications' => 'ConfirmationController',
        '/branches'     => 'BranchController',
        '/bios'         => 'BioController',
        '/customers'    => 'CustomerController',
        '/departments'  => 'DepartmentController',
        //'/initials'     => 'InitialController',
        '/nok'          => 'NOKController',
        '/roles'        => 'RoleController',
        '/staffs'       => 'StaffController',
        '/users'        => 'UserController',
        '/user_kyc'     => 'KYCController',
    ]);
});