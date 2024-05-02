<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BVNVerificationController extends Controller
{
    public function index()
    {
        if($_GET['point'] == 'customer'){
            $unverified_bvns = $this->kyc_bvn_customer_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        else if($_GET['point'] == 'guarantor'){
            $unverified_bvns = $this->kyc_bvn_guarantor_get_all('unconfirmed', true, true, $_GET['page'] ?? 1);
        }
        return response()->json([
            'unverified_addresses' => $unverified_addresses,
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
