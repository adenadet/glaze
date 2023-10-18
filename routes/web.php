<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [App\Http\Controllers\ModulesController::class, 'test'])->name('test');

//Main Area Link

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers',],function(){
    Route::get('/dashboard',    'ModulesController@dashboard')->name('dashboard');

    Route::get('/loans',        'ModulesController@loans')->name('loans');
    Route::get('/loans/{any}',        'ModulesController@loans')->where('any', '.*')->name('loans.others');

    Route::get('/notifications',        'ModulesController@notifications')->name('notifications');
    Route::get('/notifications/{any}',        'ModulesController@notifications')->where('any', '.*')->name('notifications.others');
    
    Route::get('/profile',                  'ModulesController@profile')->name('profile');
    
    Route::get('/ticketing',                'ModulesController@tickets')->name('tickets');
    Route::get('/ticketing/{any}',          'ModulesController@tickets')->where('any', '.*')->name('tickets.others');

    Route::get('/wallet',                'ModulesController@wallet')->name('wallet');
    Route::get('/wallet/{any}',          'ModulesController@wallet')->where('any', '.*')->name('wallet.others');
    
});

Route::group(['prefix' => '/staff', 'middleware' => ['auth', 'role:Staff'],'namespace' => 'App\Http\Controllers',],function(){

    Route::get('/dashboard',                        'StaffController@dashboard')->name('staff.dashboard');

    Route::get('/accounts',                        'StaffController@accounts')->name('staff.accounts');
    Route::get('/accounts/{any}',                  'StaffController@accounts')->where('any', '.*')->name('staff.accounts.others');


    Route::get('/confirm',                        'StaffController@confirmations')->name('staff.confirm');
    Route::get('/confirm/{any}',                  'StaffController@confirmations')->where('any', '.*')->name('staff.confirmations.others');

    Route::get('/customers',                        'StaffController@customers')->name('staff.customers');
    Route::get('/customers/{any}',                  'StaffController@customers')->where('any', '.*')->name('staff.customers.others');

    Route::get('/loans',                            'StaffController@loans')->name('staff.loans');
    Route::get('/loans/{any}',                      'StaffController@loans')->where('any', '.*')->name('staff.loans.others');

});

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:Admin'],'namespace' => 'App\Http\Controllers',],function(){

    Route::get('/branches',                         'AdminController@branches')->name('admin.branches');
    Route::get('/branches/{any}',                   'AdminController@branches')->where('any', '.*')->name('branches.others');

    Route::get('/departments',                      'AdminController@departments')->name('admin.departments');
    Route::get('/departments/{any}',                'AdminController@departments')->where('any', '.*')->name('departments.others');
    
    Route::get('/settings',                         'AdminController@settings')->name('settings');
    Route::get('/settings/{any}',                   'AdminController@settings')->where('any', '.*')->name('settings.others');

    Route::get('/dashboard',                        'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/loan_requirement_items',           'AdminController@loan_requirement_items')->name('admin.loan_requirement_items');
    Route::get('/loan_requirement_items/{any}',     'AdminController@loan_requirement_items')->where('any', '.*')->name('admin.loan_requirement_items.others');

    Route::get('/loan_types',                       'AdminController@loan_types')->name('admin.loan_types');
    Route::get('/loan_types/{any}',                 'AdminController@loan_types')->where('any', '.*')->name('admin.loan_types.others');

    Route::get('/staffs',                           'AdminController@staffs')->name('admin.staffs');
    Route::get('/staffs/{any}',                     'AdminController@staffs')->where('any', '.*')->name('admin.staffs.others');

    Route::get('/users',                            'AdminController@users')->name('admin.users');
    Route::get('/users/{any}',                      'AdminController@users')->where('any', '.*')->name('admin.users.others');
});

Route::group(['prefix' => '/requests', 'namespace' => 'App\Http\Controllers',],function(){
    Route::get('/guarantors/{id}/confirm',                'GuarantorController@show')->name('requests.guarantors');
    Route::get('/guarantors/{any}',          'GuarantorController@settings')->where('any', '.*')->name('settings.others');
});