<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'settings'], function () {
    //Route::put('/nominations/close/{id}', 'NominationController@close')->name('nominations.close');
    //Route::get('/nominations/open/{id}', 'NominationController@open')->name('nominations.open');
    //Route::put('/votes/close/{id}', 'VoteController@close')->name('votes.close');
    Route::apiResources([
        '/cpm_modules'                  => 'CPMModuleController',
        '/cpm_module_templates'         => 'CPMModuleTemplateController',
        '/kyc_items'                    => 'KYCItemController',
    ]);
});