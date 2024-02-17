<?php

namespace App\Http\Controllers\Api\Loans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Controller;

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

        $guarantor_request = GuarantorRequest::where('id', '=', $request->input('request_id'))->first();
        $guarantor = Guarantor::create([
            'loan_id'=> $guarantor_request->loan_id,
            'request_id'=> $request->input('request_id'),
            'title'=> $request->input('title'),
            'first_name'=> $request->input('first_name'),
            'middle_name'=> $request->input('middle_name'),
            'last_name'=> $request->input('last_name'),
            'relationship'=> $request->input('relationship'),
            'email'=> $request->input('email'),
            'phone'=> $request->input('phone'),
            'employer'=> $request->input('employer'),
            'employer_address'=> $request->input('employer_address'),
            'employer_phone'=> $request->input('employer_phone'),
            'employer_email'=> $request->input('employer_email'),
            'marital_status'=> $request->input('marital_status'),
            'relationship'=> $request->input('relationship'),
            'address'=> $request->input('address'),
            'bvn'=> $request->input('bvn'),
            'status'=> 1,
            'nationality_id' => $request->input('nationality_id'),
            'dob' => $request->input('dob'),
            'description'=> $request->input('description') ?? NULL,
            'net_income'=> $request->input('net_income'),
            'guarantor_date' => date('Y-m-d H:i:s'),
        ]);

        $guarantor_request->status = 1;
        $guarantor_request->description = $request->input('description');
        $guarantor_request->save();

        $loan = Account::where('id', '=',  $guarantor_request->loan_id)->with(['user', 'type'])->first();
        
        if (is_null($loan->guaranteed_date)){
            $loan_type = Type::where('id', '=', $loan->type_id)->with('requirements')->first();
            $guarantors = Guarantor::where('loan_id', '=', $loan->id)->where('status', '=', 1)->count();

            $guarantors_needed = 0; 

            foreach ($loan_type->requirements as $requirement){
                if ($requirement->type == 'guarantors'){
                    $guarantors_needed += $requirement->rate;
                }
            }

            if($guarantors >= $guarantors_needed){
                $loan->guaranteed_date = date('Y-m-d H:i:s');
                $loan->status = 6;
                $loan->save();

                Mail::to($loan->user->email)->send(new GuaranteedMail($loan));
            }
        }
        Mail::to($loan->user->email)->send(new ConfirmMail($loan, $guarantor));
        
        Mail::to($guarantor->email)->send(new ThanksMail($loan, $guarantor));

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
