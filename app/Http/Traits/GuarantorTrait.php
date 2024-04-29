<?php
namespace App\Http\Traits;

use App\Http\Traits\FileTrait;
use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;
use App\Models\Country;
use App\Models\Loans\Type;

use Illuminate\Support\Facades\Mail;

trait GuarantorTrait{
    use FileTrait;
    public function create_guarantor($request){
        $guarantor_request = GuarantorRequest::where('id', '=', $request->input('request_id'))->first();
        $address_proof = $request->input('address_proof') != null ? $this->file_upload_by_type($request->input('address_proof'), $request->input('address_proof_type'), 'uploads/guarantors', $request->input('request_id')) : null;
        $guarantor_signature = $request->input('guarantor_signature') != null ? $this->file_upload_by_type($request->input('guarantor_signature'), 'image', 'img/guarantors', $request->input('request_id')) : null;
        $passport = $request->input('passport') != null ? $this->file_upload_by_type($request->input('passport'), $request->input('passport_type'), 'uploads/guarantors', $request->input('request_id')) : null;
        $valid_id = $request->input('valid_id') != null ? $this->file_upload_by_type($request->input('valid_id'), $request->input('valid_id_type'), 'uploads/guarantors', $request->input('request_id')) : null;
        
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
            'guarantor_signature' => $guarantor_signature,
            'address_proof' => $address_proof,
            'valid_id' => $valid_id,
            'passport' => $passport,
        ]);

        return $guarantor;
    }

    public function guarantor_confirm_request($request){
        $guarantor_request = GuarantorRequest::where('id', '=', $request->input('request_id'))->first();
        $guarantor = $this->create_guarantor($request);

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

        return $guarantor;

    }

    public function guarantor_delete_request($id){
        $gr = GuarantorRequest::where('id', '=', $id)->first();
        
        $gr->deleted_by = auth('api')->id();
        $gr->deleted_at = date('Y-m-d H:i:s');
        $gr->status = 4;

        $gr->save();

        return $gr->loan_id;
    }

    public function guarantor_get_requests($loan_id){
        return GuarantorRequest::where('loan_id', '=', $loan_id)->with('guarantor')->latest()->get();
    }

    public function guarantor_new_request($loan, $guarantor){
        $gr = GuarantorRequest::create([
            'loan_id' => $loan->id,
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
}