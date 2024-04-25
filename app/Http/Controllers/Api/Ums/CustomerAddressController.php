<?php

namespace App\Http\Controllers\Api\Ums;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Models\Ums\CustomerAddress;
use App\Models\User;


class CustomerAddressController extends Controller
{
    use UserTrait;

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required',
            'type'      => 'required',
            'street'    => 'sometimes',
            'street2'   => 'sometimes',
            'city'      => 'required',
            'state_id'  => 'required',
            'area_id'   => 'numeric',
        ]);

        return response()->json([
            'customer_address' => $this->user_address_create_new($request),
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }

    public function show($id)
    {
        $address = CustomerAddress::where('id', '=', $id)->with(['area', 'customer', 'state', 'verification'])->first();
        
        return response()->json([
            'address' => $address,
            'address_verification' => $address->verification,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'type' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'required',
            'area_id' => 'numeric',
        ]);

        return response()->json([
            'customer_address' => $this->user_address_update($request, $id),
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }

    public function destroy($id)
    {
        $account = CustomerAddress::where('id', '=', $id)->first();

        $account->deleted_by = auth('api')->id();
        $account->deleted_at = date('Y-m-d H:i:s');

        $account->save();

        return response()->json([
            'user' => User::where('id', '=', $account->user_id)->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }
}
