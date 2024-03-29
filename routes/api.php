<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api\Chats')->middleware('auth:api')->name('api.chats.')->group(base_path('routes/api/chats.php'));
//Route::namespace('App\Http\Controllers\Api\EMR')->middleware('auth:api')->name('api.emr.')->group(base_path('routes/api/emr.php'));
//Route::namespace('App\Http\Controllers\Api\Icms')->middleware('auth:api')->name('api.icms.')->group(base_path('routes/api/icms.php'));
//Route::namespace('App\Http\Controllers\Api\Hrms')->middleware('auth:api')->name('api.hrms.')->group(base_path('routes/api/hrms.php'));
Route::namespace('App\Http\Controllers\Api\Loans')->middleware('auth:api')->name('api.loans.')->group(base_path('routes/api/loans.php'));
//Route::namespace('App\Http\Controllers\Api\Lms')->middleware('auth:api')->name('api.lms.')->group(base_path('routes/api/lms.php'));
//Route::namespace('App\Http\Controllers\Api\Som')->name('api.som.')->group(base_path('routes/api/som.php'));
Route::namespace('App\Http\Controllers\Api\Servers')->middleware(['auth:api'])->name('api.servers.')->group(base_path('routes/api/servers.php'));
Route::namespace('App\Http\Controllers\Api\Settings')->middleware(['auth:api', 'role:Super Admin'])->name('api.settings.')->group(base_path('routes/api/settings.php'));
Route::namespace('App\Http\Controllers\Api\Ticketing')->middleware('auth:api')->name('api.tickets.')->group(base_path('routes/api/ticket.php'));
Route::namespace('App\Http\Controllers\Api\ToDo')->name('api.todos.')->group(base_path('routes/api/todo.php'));

Route::namespace('App\Http\Controllers\Api\Ums')->middleware('auth:api')->name('api.ums.')->group(base_path('routes/api/ums.php'));

Route::apiResources([
    'dashboard'     => 'App\Http\Controllers\Api\DashboardController',
    'guarantor_requests'        => 'App\Http\Controllers\Api\Loans\GuarantorRequestController',
    'notices'       => 'App\Http\Controllers\Api\NoticeController',
    'policies'      => 'App\Http\Controllers\Api\PolicyController',
    //'scheduler'     => 'App\Http\Controllers\Api\EMR\RegistrationController',
]);