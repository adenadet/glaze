<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use Illuminate\Http\Request;

use App\Models\Ums\CustomerAccount;
use App\Models\User;

class CustomerAccountController extends Controller
{
    use UserTrait;
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'bank_id' => 'required',
            'account_name' => 'required',
            'account_number' => 'required|numeric',
        ]);

        CustomerAccount::create([
            'user_id' => $request->input('user_id'),
            'bank_id' => $request->input('bank_id'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'), 
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'bank_id' => 'required',
            'account_name' => 'required',
            'account_number' => 'required|numeric',
        ]);

        $account = CustomerAccount::where('id', '=', $id)->first();

        $account->user_id = $request->input('user_id');
        $account->bank_id = $request->input('bank_id');
        $account->account_name = $request->input('account_name');
        $account->account_number = $request->input('account_number'); 
        $account->status = $request->input('status');

        $account->save();

        return response()->json([
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }

    public function destroy($id)
    {
        $account = CustomerAccount::where('id', '=', $id)->first();

        $account->deleted_by = auth('api')->id();
        $account->status = 2;
        $account->deleted_at = date('Y-m-d H:i:s');
        
        $account->save();

        return response()->json([
            'user' => User::where('id', '=', $account->user_id)->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }
}
