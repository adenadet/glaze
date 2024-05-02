<?php
namespace App\Http\Traits;
use App\Http\Traits\LogTrait;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\GeminiCustomerGroup;
use App\Models\State;
use App\Models\Ums\Customer;
use App\Models\Ums\CustomerAddress;
use App\Models\Ums\CustomerAddressVerification;
use App\Models\Ums\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Http;

trait KYCTrait{
    use LogTrait;
    public function kyc_address_confirm($user_id, $address_id, $request){
        try{
            DB::beginTransaction();
            $address = CustomerAddress::where('id', '=', $request->input('address_id'))->first();
            $address->confirmed_by = auth('api')->id();
            $address->confirmed_at = date('Y-m-d H:i:s');
            $address->status = 1;
            $address->updated_by = auth('api')->id();
            $address->save();

            $verification = CustomerAddressVerification::create([
                'address_id' => $request->input('address_id'),
                'alternate_address' => $request->input('alternate_address') ?? NULL,
                'description' => $request->input('description') ?? NULL,
                'location_ease' => $request->input('location_ease'),
                'met_with' => $request->input('met_with'),
                'met_with_name' => $request->input('met_with_name') ?? NULL,
                'met_with_relations' => $request->input('met_with_relations') ?? NULL,
                'met_with_phone' => $request->input('met_with_phone') ?? NULL,
                'remarks' => $request->input('remarks'),
                'visit_update' => $request->input('visit_update'),
                'visit_date' => $request->input('visit_date'),
                'visit_date_2' => $request->input('visit_date') ?? NULL,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
            $this->log_activity_user_activity(Auth::user(), 'Address Verification', true, $address_id);
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
        }
    }

    public function kyc_address_reject($user_id, $address_id, $request){

    }

    public function kyc_address_customer_addresses($type, $detailed, $paginated, $page){
        switch($type){
            case 'confirmed':
                $query = CustomerAddress::where('status', '=', 1);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
            case 'rejected':
                $query = CustomerAddress::where('status', '=', 2);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
            case 'unconfirmed':
                $query = CustomerAddress::where('status', '=', 0);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
        }
        
        return $query;
    }

    public function kyc_address_guarantor_addresses($type, $detailed, $paginated, $page){
        switch($type){
            case 'confirmed':
                $query = CustomerAddress::where('status', '=', 1);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
            case 'rejected':
                $query = CustomerAddress::where('status', '=', 2);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
            case 'unconfirmed':
                $query = CustomerAddress::where('status', '=', 0);
                $query = $detailed ? $query->with(['area', 'customer', 'state']) : $query;
                $query = $paginated ? $query->paginate(50) : $query->get();
            break;
        }
        
        return $query;
    }
    public function kyc_bvn_confirm($user_id, $request){}

    public function kyc_bvn_reject($user_id, $request){}

    public function kyc_bvn_remind($user_id){}

    public function kyc_nin_confirm($user_id, $request){}

    public function kyc_nin_reject($user_id, $request){}

    public function kyc_nin_remind($user_id){}
}