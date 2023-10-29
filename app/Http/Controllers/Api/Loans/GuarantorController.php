<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\Guarantor\RequestMail;

class GuarantorController extends Controller
{
    public function display($id)
    {
        return response()->json([
            'account' => Account::where('id', '=', $id)->first(),
            'guarantors' => GuarantorRequest::where('loan_id', '=', $id)->get(),
        ]);
    }

    public function index()
    {
        $loans = Account::where([['status', '<', 10],['user_id', '=', auth('api')->id()]])->pluck('id');

        return response()->json([
            'requests' => GuarantorRequest::whereIN('loan_id',$loans)->with(['account', 'guarantor'])->latest()->paginate(10),
            //'loans' => $loans,
        ]);
    }

    public function add(Request $request){
        $loan = Account::where('id', '=', $request->input('loan_id'))->with('customer')->first();

        foreach ($request->input('guarantors') as $guarantor){
            $gr = GuarantorRequest::create([
                'loan_id' => $request->input('loan_id'),
                'first_name' => $guarantor['first_name'],
                'last_name' => $guarantor['last_name'],
                'email' => $guarantor['email'],
                'phone' => $guarantor['phone'],
                'status' => $guarantor['status'] ?? 0,
                'description' => $guarantor['description'] ?? NULL,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);

            Mail::to($guarantor['email'])->send(new RequestMail($loan, $gr));
        }

        return response()->json([
            'message' => 'Guarantor added successfully',       
        ]);  
    }


    public function reset(Request $request, $id)
    {
        GuarantorRequest::where('loan_id', '=', $id)->delete();
        
        foreach ($request->input('guarantors') as $guarantor){
            GuarantorRequest::create([
                'loan_id' => $request->input('loan_id'),
                'first_name' => $guarantor['first_name'],
                'last_name' => $guarantor['last_name'],
                'email' => $guarantor['email'],
                'phone' => $guarantor['phone'],
                'status' => 0,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
        }
    }

    public function resend($id)
    {
        $gr = GuarantorRequest::where('id', '=', $id)->first();
        $loan = Account::where('id', '=', $gr->loan_id)->with('customer')->first();
        
        return response()->json([
            'message' => 'Guarantor added successfully',       
        ]);  
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'loan_id' => 'required|numeric',
        ]);

        $signature = NULL; 
        $image = NULL;

        $guarantor = Guarantor::create([
            'loan_id' => $request->input('loan_id'),
            'bvn' => $request->input('bvn'),
            'title' => $request->input('title'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'relationship' => $request->input('relationship'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'employer' => $request->input('employer'),
            'employer_address' => $request->input('employer_address'),
            'marital_status' => $request->input('marital_status'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'office_phone' => $request->input('office_phone'),
            'status' => 1,
            'description' => $request->input('description'),
            'guarantor_signature' => $signature,
            'guarantor_date' => date('Y-m-d H:i:s'),
            'guarantor_passport'=> $image,
            'net_income' => $request->input('net_income'),
        ]);

        return response()->json([
            'message' => 'The loan has been successfully guaranteed',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'guarantor' => Guarantor::where('id', '=', $id)->with(['loan'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
