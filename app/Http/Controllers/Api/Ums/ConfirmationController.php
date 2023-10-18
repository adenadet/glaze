<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Ums\Customer;
use App\Models\User;
use Illuminate\Http\Request;

use App\Mail\Issues\BVNMail as BVNIssueMail;
use Illuminate\Support\Facades\Mail;

class ConfirmationController extends Controller
{
    public function index()
    {
        $customers = Customer::where('bvn_status', '!=', 1)->pluck('user_id');

        $users = User::whereIn('id', $customers)->with(['customer', 'loans'])->paginate(20);

        return response()->json([
            'users'       => $users,       
        ]);  
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'confirmation_channel' => 'required',
            'user_id' => 'required',
            'bvn_status' => 'required',
        ]);

        $customer = Customer::where('user_id', '=', $request->input('user_id'))->first();
        $customer->bvn_status = $request->input('bvn_status');
        $customer->bvn_confirmed_by = auth('api')->id();
        $customer->updated_by = auth('api')->id();
        $customer->bvn_confirmed_at = date('Y-m-d H:i:s');
        $customer->confirmation_channel = $request->input('confirmation_channel');

        $customer->save();

        return response()->json([
            'message' => 'BVN Status updated successfully',       
        ]);  
    }

    public function send_mail($id)
    {
        $user = User::where('id', '=', $id)->first();

        if (is_null($user->email) || (!filter_var($user->email, FILTER_VALIDATE_EMAIL))){
            return response()->json([
                'message' => 'User does not have a valid email address',
                'status' => 'error',
            ]);
        }

        Mail::to($user->email)->send(new BVNIssueMail($user));
        
        return response()->json([
            'message' => 'Mail has been resent successfully',
            'status' => 'success',
        ]);
    }

    public function show($id)
    {
        
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
