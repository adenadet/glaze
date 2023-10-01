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
            'unverified' => CustomerAddress::where('status', '=', 0)->whereNull('confirmed_by')->with(['area', 'customer', 'state'])->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
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

        $address = CustomerAddress::where('id', '=', $request->input('address_id'))->first();
        $address->status = 1;
        $address->confirmed_by = auth('api')->id();
        $address->confirmed_at = date('Y-m-d');
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
