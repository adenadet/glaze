<?php
namespace App\Http\Traits;

use App\Http\Traits\FileTrait;

use App\Models\Country;
use App\Models\Loans\Account;
use App\Models\Loans\AccountOfficer;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;
use App\Models\Loans\Type;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;

use Illuminate\Support\Facades\Mail;

trait LoanAccountTrait{
    use FileTrait;
    public function account_all($status=NULL, $page=1){
        if (is_null($status)){
            $query = Account::where('status', '<=', 30);
        }
        else if ($status == 'mine'){
            $query = Account::where('user_id', auth('api')->id());
        }
        else if ($status == 'account_officer'){
            $account_list = AccountOfficer::where([['status', '=', 1], ['staff_id', '=', auth('api')->id()]])->pluck('account_id');
            $query = Account::whereIn('id', $account_list);
        }
        else if ($status == 'disbursement'){
            $query = Account::where('status', '=', 16);
        }
         
        return $query->with(['cpm', 'guarantor_requests', 'repayments', 'user', 'type'])->latest()->paginate(20);
    }
    
    public function account_details($id){
        return Account::where('id', '=', $id)->with(['account_officer.staff', 'files', 'guarantors', 'type', 'user'])->first(); 
    }

    public function account_create_new($status=NULL, $page=1){

    }
}