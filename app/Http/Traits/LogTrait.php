<?php
namespace App\Http\Traits;

use App\Models\Finance\AllBank;
use Illuminate\Support\Facades\Http;

use App\Models\Log\Activity;

trait LogTrait{
    public function log_approve_file($user, $status, $loan_id){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has '.($status == 1 ? 'approved' : 'rejected').' a  file for loan with id: '.$loan_id,
            'url' => 'Loan File Approval',
            'method' => 'approval', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }

    public function log_createLoginActivity($user, $status){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has '.($status ? 'successfully logged in': 'failed to log in'),
            'url' => 'New Login Attempt',
            'method' => 'auth', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }

    public function log_createNewLoanActivity($user, $status){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has requested for a loan',
            'url' => 'New Loan Request',
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }

    public function log_activity_update_loan($user, $loan){
        $activity = Activity::create([
            'subject' => ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').' has updated for a loan with id: '.$loan->unique_id,
            'url' => 'New Loan Request',
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }

    public function log_activity_user_activity($user, $type, $status, $item_id){
        switch ($type){
            case 'Address Verification':
                $subject = ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').($status ? ' has verified' : ' failed to verify').' a Customer Address with id: '.$item_id;
                $method = 'verify';
            break;
            case 'Customer Creation Self':
                $subject = $user->first_name.' '.$user->last_name.' has successfully registered';
                $method = 'create';
            break;
            case 'Guarantor Request Create':
                $subject =  ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').($status ? ' has created' : ' failed to create').' a Guarantor for Loan of id: '.$item_id;
                $method = 'delete';
            break;
            case 'Guarantor Request Delete':
                $subject =  ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').($status ? ' has deleted' : ' failed to delete').' a Guarantor Request with id: '.$item_id;
                $method = 'delete';
            break;
        
            default:
                $subject = ($user ? $user->first_name.' '.$user->last_name: 'Unknown user').($status ? ' has acted' : ' action failed on ').' an Element with id: '.$item_id;
                $method = 'action';
            break;
        }
        Activity::create([
            'subject' => $subject,
            'url' => url()->current(),
            'method' => $method, 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user ? $user->id : 0,
        ]);
    }
}