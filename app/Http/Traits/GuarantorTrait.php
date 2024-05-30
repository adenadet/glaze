<?php
namespace App\Http\Traits;

use App\Http\Traits\FileTrait;
use App\Http\Traits\LogTrait;
use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;
use App\Models\Country;
use App\Models\Loans\Type;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait GuarantorTrait{
    use FileTrait, LogTrait;
    public function create_guarantor($request){
        DB::beginTransaction();
        try{
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
                'residential_address'=> $request->input('residential_address'),
                'bvn'=> $request->input('bvn'),
                'status'=> 1,
                'nationality_id' => $request->input('nationality_id'),
                'nin' => $request->input('nin'),
                'dob' => $request->input('dob'),
                'description'=> $request->input('description') ?? NULL,
                'net_income'=> $request->input('net_income'),
                'guarantor_date' => date('Y-m-d H:i:s'),
                'guarantor_signature' => $guarantor_signature,
                'address_proof' => $address_proof,
                'valid_id' => $valid_id,
                'passport' => $passport,
            ]);
            DB::commit();
        return $guarantor;
        }
        catch (Exception $e){
            print_r ($e->getMessage());
            return null;
        }
    }

    public function guarantor_confirm_request($request){
        DB::beginTransaction();
        try{
            $guarantor_request = GuarantorRequest::where('id', '=', $request->input('request_id'))->first();
            $guarantor = $this->create_guarantor($request);
            if ($guarantor){
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
            }
            DB::commit();    
            Mail::to($loan->user->email)->send(new ConfirmMail($loan, $guarantor));
            
            Mail::to($guarantor->email)->send(new ThanksMail($loan, $guarantor));

            return $guarantor;

        }
        catch(Exception $e){
            DB::rollback();
        }

    }

    public function guarantor_delete_request($id){
        try{
            DB::beginTransaction();

            $gr = GuarantorRequest::where('id', '=', $id)->first();
            
            $gr->deleted_by = auth('api')->id();
            $gr->deleted_at = date('Y-m-d H:i:s');
            $gr->status = 4;
            $gr->save();

            $guarantor = Guarantor::where('request_id', '=', $gr->id)->first();
            
            if ($guarantor){
                $guarantor->deleted_at = date('Y-m-d H:i:s');
                $guarantor->deleted_by = auth('api')->id();
                $guarantor->save();
            }
            $this->log_activity_user_activity(Auth::user(), 'Guarantor Request Delete', true, $id);
            DB::commit();
            
            return $gr->loan_id;
        }
        catch (Exception $e){
            DB::rollback();
            $this->log_activity_user_activity(Auth::user(), 'Guarantor Request Delete', false, $id);
        }
    }

    public function guarantor_get_requests($loan_id){
        return GuarantorRequest::where('loan_id', '=', $loan_id)->with('guarantor')->latest()->get();
    }

    public function guarantor_get_guarantor_by_id($id){
        return Guarantor::where('id', '=', $id)->first();
    }

    public function guarantor_new_request($request){
        try{
            DB::beginTransaction();
            $loan = Account::where('id', '=', $request->input('loan_id'))->with('user')->first();
            foreach ($request->input('guarantors') as $guarantor){
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
            $this->log_activity_user_activity(Auth::user(), 'Guarantor Request Create', false, $request->input('loan_id'));
            DB::commit();

            return 'Completed';
        }
        catch(Exception $e){
            DB::rollBack();
            $this->log_activity_user_activity(Auth::user(), 'Guarantor Request Create', false, $request->input('loan_id'));
        }
    }

    public function guarantor_reject_request($request){
        try{
            DB::beginTransaction();
            $gr = GuarantorRequest::where('id', '=', $request->input('request_id'))->first();

            $gr->first_name = $request->input('first_name');
            $gr->other_name = $request->input('other_name');
            $gr->last_name = $request->input('last_name');
            $gr->email = $request->input('email');
            $gr->title = $request->input('title');
            $gr->description = $request->input('comment');
            $gr->status = 2;

            $gr->save();
            
            DB::commit();
            return 'Completed';
        }
        catch(Exception $e){
            DB::rollBack();
        }
    }
}