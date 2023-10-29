<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'loans'], function () {
    Route::get('/accounts/initials', 'AccountController@initials')->name('accounts.initialize');
    Route::get('/accounts/staffs', 'AccountController@staffs')->name('accounts.staffs');
    Route::get('/accounts/staffs/{id}', 'AccountController@staff_show')->name('accounts.staff_show');
    Route::get('/accounts/customer/{id}', 'AccountController@customer')->name('accounts.customer');
    Route::get('/accounts/credit_scores/{id}', 'AccountController@credit_scores')->name('accounts.credit_scores');
    Route::get('/accounts/pending', 'AccountController@pending')->name('accounts.pending');
    Route::get('/confirms/initials/{id}', 'ConfirmationController@initials')->name('confirms.initialize');
    Route::get('/guarantors/loans/{id}', 'GuarantorController@display')->name('guarantors.loans');
    Route::get('/repayments/initials', 'RepaymentController@initials')->name('repayments.initialize');
    Route::get('/types/initials', 'TypeController@initials')->name('types.initialize');
    Route::post('/guarantors/add', 'GuarantorController@add')->name('guarantors.add');
    Route::put('/guarantors/reset/{id}', 'GuarantorController@reset')->name('guarantors.reset');

    Route::apiResources([
        '/accounts'         => 'AccountController',
        '/account_officers' => 'AccountOfficerController',
        '/confirms'         => 'ConfirmationController',
        '/checklists'       => 'CheckListController',
        '/guarantors'       => 'GuarantorController',
        '/repayments'       => 'RepaymentController',
        '/requirements'     => 'RequirementController',
        '/types'            => 'TypeController',
    ]);
});