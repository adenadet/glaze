<?php
namespace App\Http\Traits;

use App\Http\Traits\FileTrait;
use App\Http\Traits\LogTrait;

use App\Models\Ums\Customer;
use App\Models\Loans\Guarantor;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;

use App\Mail\Loans\AssignmentMail;
use App\Mail\Loans\NewAccountOfficerMail;
use App\Models\Loans\GuarantorAddressVerification;
use App\Models\Ums\CustomerAddressVerification;
use Illuminate\Support\Facades\Mail;

trait ApprovalTrait{
    use LogTrait;

    public function approval_address_confirm_address($request, $id, $type){
        $customer_address_verification = CustomerAddressVerification::create([
            'address_type' => $type,
            'guarantor_id' => $id,
            'alternate_address' => $request->input('alternate_address'),
            'description' => $request->input('description'),
            'location_ease' => $request->input('location_ease'),
            'met_with' => $request->input('met_with'),
            'met_with_name' => $request->input('met_with_name'),
            'met_with_relations' => $request->input('met_with_relations'),
            'met_with_phone' => $request->input('met_with_phone'),
            'remarks' => $request->input('remarks'),
            'visit_update' => $request->input('visit_update'),
            'visit_date' => $request->input('visit_date'),
            'visit_date_2' => $request->input('visit_date_2'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        if ($type == 'customer'){}
        else if($type == 'guarantor'){}
    }

    public function approval_address_get_all($type, $status, $paginated, $detailed){
        switch ($type){
            case 'customer':
                if ($status == 'confirmed'){}
                else if ($status == 'rejected'){}
                else if ($status == 'unconfirmed'){}
            break;
            case 'guarantor':
                if ($status == 'confirmed'){}
                else if ($status == 'rejected'){}
                else if ($status == 'unconfirmed'){}
            break;
        }
    }

    public function approval_bvn_get_all($type, $status, $paginated, $detailed){
        switch ($type){
            case 'customer':
                if ($status == 'confirmed'){
                    $query = Customer::where('bvn_status', '=', 1);
                }
                else if ($status == 'rejected'){
                    $query = Customer::where('bvn_status', '=', 2);
                }
                else if ($status == 'unconfirmed'){
                    $query = Customer::where('bvn_status', '=', 0);
                }
                $query = $query->with(['user'])->orderBy('updated_at', 'DESC');
            break;
            case 'guarantor':
                if ($status == 'confirmed'){
                    $query = Guarantor::where('approval_status', '=', 1);
                    $query = $detailed ?  $query->with(['state', 'area']): $query;
                }
                else if ($status == 'rejected'){
                    $query = Guarantor::where('approval_status', '=', 2);
                }
                else if ($status == 'unconfirmed'){
                    $query = Guarantor::where('approval_status', '=', 0)->orWhereNull('approval_status');
                }
            break;

            $quest = $paginated ? $query->paginate(30) : $query->get();
        }
    }
}