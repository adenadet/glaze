<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\Finance\AllBank;
use App\Models\Finance\Bank;
use App\Models\Finance\Bureau;
use App\Models\Finance\BureauProduct;
use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\Type;
use App\Models\Loans\Repayment;
use App\Models\User;
use App\Models\Area;
use App\Models\Loans\CreditScore;
use App\Models\Loans\CheckListItem;
use App\Models\Loans\Disbursement;
use App\Models\Loans\TypeRequirement;
use App\Models\State;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

use App\Http\Traits\GeminiTrait;

class AccountController extends Controller{

    use GeminiTrait;

    public function credit_scores($id)
    {
        
    }
    
    public function customer($id)
    {
        return response()->json([
            'all_banks' => AllBank::select('id', 'bank_name')->orderBy('bank_name', 'ASC')->get(),
            'loan_types' => Type::where('status', '1')->get(),       
            'accounts' => Account::where('user_id', '=', $id)->with(['repayments', 'guarantor_requests', 'type', 'guarantors'])->latest()->paginate(10),
        ]);
    }

    public function initials()
    {
        return response()->json([
            'all_banks' =>  $this->get_gemini_banks(),
            'accounts' => Account::where('user_id', auth('api')->id())->with(['repayments', 'guarantor_requests', 'guarantors'])->get(),
            'user'=> User::where('id', '=', auth('api')->id())->with(['customer_address', 'customer_accounts', 'next_of_kin'])->first(),
            'current_loan' => Account::where('user_id', auth('api')->id())->where('status', '<', 5)->with(['guarantor_requests', 'guarantors', 'repayments'])->first(),
            'loan_types' => $this->get_gemini_loan_products(),
        ]);
    }

    public function index()
    {
        return response()->json([      
            'accounts' => Account::where('user_id', auth('api')->id())->with([ 'guarantor_requests', 'repayments', 'user', 'type', ])->latest()->paginate(20),
        ]);
    }

    public function pending()
    {
        return response()->json([      
            'accounts' => Account::where('status','<', 5)->with(['user', 'type',])->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'loan_type_id' => 'required|numeric',
            'amount'=> 'required|numeric',
            'duration'=> 'required|numeric',
            'bank_id' => 'required|numeric',
            'acct_name' => 'required',
            'acct_number' => 'required|numeric',
        ]);

        $loan_type = Type::where('ProductCode', '=', $request['loan_type_id'])->with('requirements')->first();

        $principal = $request->input('amount');
        
        $interest = $loan_type->percentage / 5200;
        
        $x = pow(1 + $interest, $request->input('duration'));
        
        $emiMonthly =  ($principal  * $x * $interest) / ($x-1);
        
        $bank = AllBank::where('bank_code', '=', $request->input('bank_id'))->first();

        $loan = Account::create([
            'type_id' => $request['loan_type_id'],
            'user_id' => $request->input('user_id') ?? auth('api')->id(),
            'amount' => $request['amount'],
            'payable' => round(($emiMonthly * $request->input('duration')), 2),
            'emi' => round(($emiMonthly), 2),
            'balance' => round(($emiMonthly), 2),
            'duration' => $request->input('duration'),
            'frequency' => $request->input('frequency'),
            'name' => $request->input('name') ?? 'Loan',
            'bank_id' => $bank->id,
            'acct_name' => $request->input('acct_name'),
            'acct_number' => $request->input('acct_number'),
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

        $user = User::find($request->input('user_id'));

        return response()->json([
            'current_loan' => $loan,       
            'message' => 'Successfully created, kindly add guarantors',
        ]);
    }
    
    public function show($id)
    {
        return response()->json([
            'account' => Account::where('id', '=', $id)->with(['account_officer.staff', 'user', 'type', 'guarantors'])->first(),
            'repayments' => Repayment::where('loan_id', '=', $id)->with(['bank'])->latest()->paginate(20),     
        ]);    
    }

    public function staffs()
    {
        return response()->json([
            'accounts' => Account::where('status', '<=', 13)->with(['bank', 'type', 'user', 'account_officer.staff'])->latest()->paginate(50),
        ]);
    }

    public function staff_show($id)
    {
        $account = Account::where('id', '=', $id)->with(['bank', 'type', 'user', 'account_officer'])->first();
        $requirements = TypeRequirement::select('requirement_id')->where('loan_type_id', '=', $account->type_id)->with('requirement')->get();
        $loan_requirements = CheckListItem::where('loan_id', '=', $id)->with('requirement')->get();

        return response()->json([
            'account' => $account,
            'requirements' => $requirements,
            'loan_requirements' => $loan_requirements,
        ]);
    }

    public function update(Request $request, $id)
    {
        $loan = Account::find($id);
        
        //Check if the number are still valid
        $user = User::find($loan->user_id);
        //$saving = Saving::where('user_id', '=', $user->id)->where('name', 'LIKE', '%Contribution%')->where('status', '=', 1)->first();
        
        return response()->json([
            'loan' => $loan,
            'status' => 'error',
            'message' => 'Not Yet Guaranteed 1',
            'accounts' => Bank::all(),
            'all_banks' => AllBank::orderBy('bank_name', 'ASC')->get(),
            'branches' => Branch::with('users.savings')->get(),      
            //'savings' => Saving::where('user_id',  auth('api')->id())->get(),
            'loans' => Account::where('status', '=', 0)->with('user.branch')->with('payment_bank')->with('loan_guarantors.guarantor')->orderBy('requested_date', 'ASC')->get(),      
        ]);
        
    }

    public function destroy($id)
    {
        $loan = Account::where('id', '=', $id)->first();

        $loan->status = 3;
        $loan->deleted_by = auth('api')->id();
        $loan->deleted_at = date('Y-m-d H:i:s');
        $loan->save();

        return response()->json([      
            'accounts' => Account::where('user_id', auth('api')->id())->with([ 'guarantor_requests', 'repayments', 'user', 'type', ])->latest()->paginate(20),
        ]);
    }

    private function sendSMS($number, $message = "Thanks for registering"){
        $client = new Client();
        $url = 'http://customer.smsprovider.com.ng/api/?username=adenadet01@gmail.com&password=yetunde01&message='.$message.'&sender=DLCIK&mobiles='.$number;
        $response = $client->request('GET', $url);
        $body = json_decode($response->getBody() , true);
        
        return $body['status'];
    }
}
