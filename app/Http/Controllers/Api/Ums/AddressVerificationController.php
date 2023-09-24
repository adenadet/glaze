<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Ums\Customer;
use App\Models\Ums\CustomerAddress;
use App\Models\Ums\CustomerAddressVerification;
use Illuminate\Http\Request;

class AddressVerificationController extends Controller
{   
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
        return response()->json([
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $verification = CustomerAddressVerification::create([
            'customer_id' => $request->input('customer_id'),
            'customer_address' => $request->input('customer_address'),
            'date_of_visit' => $request->input('date_of_visit'),
            'date_of_visit_additional' => $request->input('date_of_visit_additional') ?? NULL,
            'found_address' => $request->input('found_address'),
            'alt_address' =>  $request->input('alt_address') ?? NULL,
            'person_met_status'  => $request->input('person_met_status'),
            'person_met' => $request->input('person_met') ?? NULL,
            'ease_of_location' => $request->input('ease_of_location'),
            'description' => $request->input('description'),
            'verification_officer_id' => auth('api')->id(),
            'verification_officer_signature' => NULL,
            'verification_date' => $request->input('verification_date') ?? date('Y-m-d'),
            'status' => 1,
        ]);

        $address = CustomerAddress::where('user_id', '=', $request->input('customer_id'))->first();
        $address->status = 1;
        $address->save();

        return response()->json([
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->get(),
        ]); 
    }

    public function show($id)
    {
        return response()->json([
            'address_verification' => CustomerAddress::where('id', '=', $id)->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $verification = CustomerAddressVerification::where('id', '=', $id)->first();
        
        $verification->customer_id = $request->input('customer_id');
        $verification->customer_address = $request->input('customer_address');
        $verification->date_of_visit = $request->input('date_of_visit');
        $verification->date_of_visit_additional = $request->input('date_of_visit_additional') ?? NULL;
        $verification->found_address = $request->input('found_address');
        $verification->alt_address =  $request->input('alt_address') ?? NULL;
        $verification->person_met_status = $request->input('person_met_status');
        $verification->person_met = $request->input('person_met') ?? NULL;
        $verification->ease_of_location = $request->input('ease_of_location');
        $verification->description = $request->input('description');
        $verification->verification_officer_id = auth('api')->id();
        $verification->verification_officer_signature = NULL;
        $verification->verification_date = $request->input('verification_date') ?? date('Y-m-d');
        $verification->status = 1;
        
        $verification->save();

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
