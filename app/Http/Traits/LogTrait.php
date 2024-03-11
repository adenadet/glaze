<?php
namespace App\Http\Traits;

use App\Models\Finance\AllBank;
use Illuminate\Support\Facades\Http;

use App\Models\Log\Activity;

trait LogTrait{
    public function createLoginActivity($user, $status){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has '.($status ? 'successfully logged in': 'failed to log in'),
            'url' => 'New Login Attempt',
            'method' => 'auth', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }

    public function createNewLoanActivity($user, $status){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has requested for a loan',
            'url' => 'New Loan Request',
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }
}