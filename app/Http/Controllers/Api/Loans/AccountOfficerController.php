<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loans\Account;
use App\Models\Loans\AccountOfficer;
use Illuminate\Http\Request;

class AccountOfficerController extends Controller
{
    public function index()
    {
        $account_list = AccountOfficer::where([['status', '=', 1], ['staff_id', '=', auth('api')->id()]])->pluck('account_id');
        $accounts = Account::whereIn('id', $account_list)->with(['repayments', 'user', 'type', 'cpm'])->paginate(20);

        return response()->json([
            'accounts' => $accounts,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
        ]);

        $accounts = AccountOfficer::where('account_id', '=', $request->input('account_id'))->get();

        foreach ($accounts as $account) {
            $account->status = 2;
            $account->save();
        }

        AccountOfficer::create([
            'account_id' => $request->input('account_id'),
            'staff_id' => $request->input('staff_id'),
            'status' => $request->input('status') ?? 1,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'accounts' => Account::where('user_id', auth('api')->id())->with(['repayments', 'user', 'type'])->paginate(20),
            'account' => Account::where('id', '=',  $request->input('account_id'))->first(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
