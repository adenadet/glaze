<?php
namespace App\Http\Traits;

use App\Http\Traits\FileTrait;

use App\Models\Country;
use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\AccountOfficer;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;
use App\Models\Loans\Repayment;
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

    public function account_create_new($request){
        $loan_type = Type::where('ProductCode', '=', $request['loan_type_id'])->with('requirements')->first();
            
        if ($loan_type->interest_type == 'Flat'){
            $principal = $request->input('amount');
            $rate = 0.6 ;
            $time = $request->input('frequency') == 'weeks' ? ($request->input('duration') / 52) : ($request->input('duration') / 12);
            $totalPayment = $request->input('amount') * (1 + ($rate * $time));
            $emiMonthly =  $totalPayment / $request->input('duration');
        }

        else if($loan_type->interest_type == 'Reducing'){    
            $principal = $request->input('amount');
            $interest = $request->input('frequency') == 'weeks' ? $loan_type->percentage / 5200 : $loan_type->percentage / 1200;
            $x = pow(1 + $interest, $request->input('duration'));
            $emiMonthly =  ($principal  * $x * $interest) / ($x-1);    
        }

        $bank = AllBank::where('bank_code', '=', $request->input('bank_id'))->first();

        $signaturePad = NULL;
        if (!is_null($request->input('signature'))){
            $signature_pad = time().".".explode('/',explode(':', substr( $request->input('signature'), 0, strpos($request->input('signature'), ';')))[1])[1];
            \Image::make($request->input('signature'))->save(public_path('img/consents/').$signature_pad);
            $signaturePad = $signature_pad;
        }

        $loan = Account::create([
            'type_id' => $loan_type->id,
            'user_id' => $request->input('user_id') ?? auth('api')->id(),
            'amount' => $request->input('amount'),
            'payable' => round(($emiMonthly * $request->input('duration')), 2),
            'emi' => round(($emiMonthly), 2),
            'balance' => round(($emiMonthly), 2),
            'duration' => $request->input('duration'),
            'frequency' => $request->input('frequency'),
            'name' => $request->input('name') ?? 'Loan',
            'bank_id' => $bank->id,
            'acct_name' => $request->input('acct_name'),
            'acct_number' => $request->input('acct_number'),
            'signature' => $signaturePad,
            'total_paid' => 0,
            'status' => 2,
            'status_date' => date('Y-m-d H:i:s'),
            'request_date' => date('Y-m-d H:i:s'),
            'request_by' => $request->input('user_id') ?? auth('api')->id(), 
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),    
        ]);

        $loan->unique_id =  config('app.short_code').sprintf('%08d', $loan->id);
        $loan->save();

        return $loan;
    }

    public function account_get_account_repayments($id){
        return Repayment::where('loan_id', '=', $id)->get();
    }
}