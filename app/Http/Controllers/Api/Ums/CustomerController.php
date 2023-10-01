<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Hrms\Employee;
use App\Models\Loans\Account;
use App\Models\Ums\Customer;
use Illuminate\Http\Request;
use App\Models\Ums\CustomerAddress;
use App\Models\User;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::select('user_id')->where('status', '<', 2)->get();
        return response()->json([
            'customers' => User::whereIn('id', $customers)->with(['next_of_kin', 'customer_accounts', 'customer_address.state', 'social_medias', 'customer_kyc'])->orderBy('last_name', 'ASC')->paginate(50),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'type' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
        ]);

        CustomerAddress::create([
            'user_id' => $request->input('user_id'),
            'type' => $request->input('type'),
            'street' => $request->input('street'),
            'street_2' => $request->input('street2'),
            'city' => $request->input('city'),
            'state_id' => $request->input('state_id'),
            'area_id' => $request->input('area_id'),
            'status' => $request->input('status') ?? 0,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->first(),
        ]);

    }

    public function show($id)
    {
        //$staffs = Employee::select('user_id')->get();
        return response()->json([
            'customer' => User::where('id', '=', $id)->with('next_of_kin', 'customer_accounts', 'customer_address', 'social_medias', 'customer_kyc')->first(),
            'customer_address' => CustomerAddress::where('user_id', '=', $id)->with(['area', 'state', 'verifier'])->first(),
            'all_loans_cnt' => Account::where('user_id', '=', $id)->where('status', '>=', '5')->count(),
            'completed_loans_cnt' => Account::where('user_id', '=', $id)->where('status', '=', '10')->count(),
            //'staffs' => User::whereIn('id', $staffs)->orderBy('last_name', 'ASC')->get(),
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
            'state_id' => 'numeric',
            'area_id' => 'numeric',
        ]);

        $account = CustomerAddress::where('id', '=', $id)->first();

        $account->user_id = $request->input('user_id');
        $account->type = $request->input('type');
        $account->street = $request->input('street');
        $account->street_2 = $request->input('street2');
        $account->city = $request->input('city');
        $account->state_id = $request->input('state_id');
        $account->area_id = $request->input('area_id');
        $account->status = $request->input('status') ?? 0;
        $account->created_by = auth('api')->id();
        $account->updated_by = auth('api')->id();
        
        $account->save();

        return response()->json([
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