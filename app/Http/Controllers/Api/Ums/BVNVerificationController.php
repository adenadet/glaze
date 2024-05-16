<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\KYCTrait;
use App\Http\Traits\GuarantorTrait;
use App\Http\Traits\UserTrait;

class BVNVerificationController extends Controller
{
    use KYCTrait, GuarantorTrait, UserTrait;
    public function index()
    {
        if($_GET['point'] == 'customer'){
            $unverified_bvns = $this->kyc_bvn_customer_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        else if($_GET['point'] == 'guarantor'){
            $unverified_bvns = $this->kyc_bvn_guarantor_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        return response()->json([
            'unverified_bvns' => $unverified_bvns,
        ]);
    }

    public function reject(Request $request, $id){

    }

    public function store(Request $request)
    {
        if($_GET['point'] == 'customer'){
            $unverified_bvns = $this->kyc_bvn_customer_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        else if($_GET['point'] == 'guarantor'){
            $unverified_bvns = $this->kyc_bvn_guarantor_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        return response()->json([
            'unverified_bvns' => $unverified_bvns,
        ]);
    }

    public function show($id)
    {
        if($_GET['point'] == 'customer'){
            $user = $this->user_get_customer_by_user_id($id);
        }
        else if($_GET['point'] == 'guarantor'){
            $user = $this->guarantor_get_guarantor_by_id($id);
        }
        return response()->json([
            'user' => $user,
        ]);
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
