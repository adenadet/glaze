<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loans\AccountOfficer;
use Illuminate\Http\Request;

class AccountOfficerController extends Controller
{
    public function index()
    {
        $accounts = AccountOfficer::select('id')->where('status', '=', 1)->where('staff_id', '=', auth('api')->id())->get();

        return response()->json([
            '' => 'Loan Account has been assigned successfully'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
        ]);

        $account_officer = AccountOfficer::create([
            'account_id' => $request->input('account_id'),
            'staff_id' => $request->input('staff_id'),
            'status' => $request->input('status') ?? 0,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'message' => 'Loan Account has been assigned successfully'
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
