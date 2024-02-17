<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'servers'], function () {
    /*Route::put('/accounts/disburse/{id}', 'AccountController@disbursement')->name('accounts.disbursement');
    Route::get('/guarantors/resend/{id}', 'GuarantorController@resend')->name('guarantors.resend');*/

    //Route::get()
    Route::post('/first_central/getCreditScore', 'FirstCentralController@getCreditScore')->name('first_central.getCreditScore');
    Route::post('/first_central/validate', 'FirstCentralController@validateToken')->name('first_central.validate');

    Route::post('periculum/login', 'PericulumController@login')->name('periculum.login');
    Route::post('periculum/validate', 'PericulumController@validateToken')->name('periculum.validate');
    Route::post('periculum/bvn_check', 'PericulumController@bvn_query')->name('periculum.bvn_check');

    Route::apiResources([
        '/first_central'         => 'FirstCentralController',
        '/periculum'             => 'PericulumController',
    ]);
});