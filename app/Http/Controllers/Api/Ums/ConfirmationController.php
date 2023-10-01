<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Ums\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index()
    {
        $customers = Customer::where('bvn_status', '=', 0)->pluck('user_id');

        $users = User::whereIn('id', $customers)->paginate(20);

        return response()->json([
            'users'       => $users,       
        ]);  
    }

    public function store(Request $request)
    {
        //
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
