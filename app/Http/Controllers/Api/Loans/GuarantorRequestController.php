<?php

namespace App\Http\Controllers\Api\Loans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;
use App\Http\Traits\GuarantorTrait;

use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;
use App\Models\Country;
use App\Models\Loans\Type;



class GuarantorRequestController extends Controller
{
    use GuarantorTrait;
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'request_id'=> 'required|numeric',
            'title'=> 'required',
            'first_name'=> 'required',
            'middle_name'=> 'sometimes',
            'last_name'=> 'required',
            'relationship'=> 'required',
            'email'=> 'required|email',
            'phone'=> 'required',
            'employer'=> 'required',
            'employer_address'=> 'required',
            'employer_phone'=> 'required',
            'employer_email'=> 'required|email',
            'marital_status'=> 'required',
            'relationship'=> 'required',
            'address'=> 'required',
            'bvn'=> 'required|numeric',
            'nationality_id' => 'required|numeric',
            'dob' => 'required|date',
            'net_income'=> 'required',
        ]);

        $this->guarantor_confirm_request($request);

        
        return response()->json([
            'guarantor' => $guarantor,
            'status' => 'Guarantorship successfully added',
        ]);
    }

    public function show($id)
    {
        $request = GuarantorRequest::where('id', '=', $id)->first();
        $account = Account::where('id', '=',  $request->loan_id)->with(['guarantor_requests', 'user', 'type'])->first();
        if ($request->status == 1){
            return response()->json([
                'status' => 'Error',
                'message' => 'You have already guaranteed this loan',
                'account' => $account,
            ]);    
        }
        else if ($request->status == 2){
            return response()->json([
                'status' => 'Error',
                'message' => 'You have already rejected this loan',
                'account' => $account,
            ]);
        }
        else{
            return response()->json([
                'status' => 'Pending',
                'account' => $account,
                'guarantors' => GuarantorRequest::where('loan_id', '=', $id)->get(),
                'nations' => Country::select('id', 'name')->orderBy('name', 'ASC')->get(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
