<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Http\Traits\KYCTrait;
use App\Models\Ums\Customer;
use App\Models\Ums\CustomerAddress;
use App\Models\Ums\CustomerAddressVerification;
use Illuminate\Http\Request;

class AddressVerificationController extends Controller
{   
    use KYCTrait;
    public function awaiting_confirmation()
    {
        return response()->json([
            'unverified' => CustomerAddressVerification::where('status', '=', 1)->paginate(20),
        ]);
    }

    public function awaiting_coo()
    {
        return response()->json([
            'unverified' => CustomerAddressVerification::where('status', '=', 2)->paginate(10),
        ]);
    }

    public function confirm(Request $request, $id)
    {
        $verification = CustomerAddressVerification::where('id', '=', $id)->first();

        $verification->status = 2;
        $verification->account_officer_id = auth('api')->id();
        $verification->account_officer_remark = $request->input('remark');
        $verification->account_officer_at = date('Y-m-d H:i:s');
        $verification->save();

        return response()->json([
            'message' => "Updated awaiting COO confirmation",
        ]);
    }

    public function coo(Request $request, $id)
    {
        $verification = CustomerAddressVerification::where('id', '=', $id)->first();

        $verification->status = 3;
        $verification->confirmed_by = auth('api')->id();
        $verification->confirmed_at = date('Y-m-d H:i:s');
        $verification->save();

        $customer_address = CustomerAddress::where('customer_id', '=', $verification->customer->id)->first();
        $customer_address->status = 2;
        $customer_address->confirmed_by = auth('api')->id();
        $customer_address->confirmed_at = date('Y-m-d H:i:s');

        $customer_address->save();

        return response()->json([
            'message' => "Updated awaiting COO confirmation",
        ]);

    }

    public function index()
    {
        if($_GET['point'] == 'customer'){
            $unverified_addresses = $this->kyc_address_customer_addresses('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        else if($_GET['point'] == 'guarantor'){
            $unverified_addresses = $this->kyc_address_guarantor_addresses('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        return response()->json([
            'unverified_addresses' => $unverified_addresses,
        ]);
    }
    
    public function reject(Request $request){
        return response()->json([
            'address_verification' => 'Rejected',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'address_verification' => CustomerAddress::where('id', '=', $id)->first(),
        ]);
    }


    public function store(Request $request)
    {
        //dd($request->input('type'));
        if (is_null($request->input('type'))){
            $verification = $this->kyc_address_customer_address_confirm($request);
        }
        else if($request->input('type') == 'guarantor'){
            $verification = $this->kyc_address_guarantor_address_confirm($request);
        } 
        
        return response()->json([
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->get(),
        ]); 
    }

    public function update(Request $request, $id)
    {
        $verification = CustomerAddressVerification::where('id', '=', $id)->first();
        
        $verification->alternate_address = $request->input('alternate_address');
        $verification->description = $request->input('description');
        $verification->location_ease = $request->input('location_ease');
        $verification->met_with = $request->input('met_with');
        $verification->met_with_name = $request->input('met_with_name');
        $verification->met_with_relations = $request->input('met_with_relations');
        $verification->met_with_phone = $request->input('met_with_phone');
        $verification->remarks = $request->input('remarks');
        $verification->visit_update = $request->input('visit_update');
        $verification->visit_date = $request->input('visit_date');
        $verification->visit_date_2 = $request->input('visit_date_2');
        $verification->updated_by = auth('api')->id();
        
        $verification->save();

        $address = CustomerAddress::where('id', '=', $request->input('address_id'))->first();
        $address->status = 1;
        $address->confirmed_by = auth('api')->id();
        $address->confirmed_at = date('Y-m-d');
        $address->save();

        return response()->json([
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->get(),
        ]); 

    }

    public function destroy($id)
    {
        $verification = CustomerAddressVerification::where('id', '=', $id)->first();
        
        $verification->deleted_by = auth('api')->id();
        $verification->deleted_at = date('Y-m-d H:i:s');

        $verification->save();

        $customer_address = CustomerAddress::where('customer_id', '=', $verification->customer->id)->first();
        $customer_address->status = 0;
        $customer_address->confirmed_by = NULL;
        $customer_address->confirmed_at = NULL;

        $customer_address->save();

        return response()->json([
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->get(),
        ]);
    }
}
