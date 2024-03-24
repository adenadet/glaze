<?php

namespace App\Http\Controllers\Api\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\EMR\Appointment;
use App\Models\EMR\Patient;
use App\Models\EMR\RadFinding;
use App\Models\EMR\Schedule;
use App\Models\EMR\Service;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\Finance\BureauProduct;
use App\Models\Loans\Account;
use App\Models\Loans\CreditScore;
use App\Models\User;


class FirstCentralController extends Controller
{
    public function index()
    {
        $feedback = Http::withOptions(['debug' => true, 'verify' => false,])
        ->post(config('app.first_central_url').'/login', [
            'username' => config('app.first_central_user'),
            'password' => config('app.first_central_password')
        ]);
        return json_decode($feedback);
    }

    public function validateToken(Request $request){
        $route = config('app.first_central_url').'/ValidateTicket';
        $feedback = Http::withOptions(['verify' => false,])->post($route, [
            'DataTicket' => $request->input('token'),
        ]);
        return json_decode($feedback);
    }

    public function getCreditScore(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required|numeric',
            'loan_id' => 'required|numeric',
        ]);
        
        //Get Variables
        $product = BureauProduct::where('id', '=', $request->input('product_id'))->first();
        $loan = Account::where('id', '=', $request->input('loan_id'))->first();
        $route = config('app.first_central_url').'/'.$product->link;
        
        if ($product->type == 'Individual'){
            $body = [
                'DataTicket' => $request->input('DataTicket'),
                'EnquiryReason' => "Request for Loan",
                'ConsumerName' => "",
                'DateOfBirth' =>"",
                'Identification' => $request->input('Identification'),
                'Accountno' => "",
                'ProductID' => $product->bureau_product_id,
            ];
        }

        else{
            $body = [
                'DataTicket' => $request->input('DataTicket'),
                'EnquiryReason' => "Request for Loan",
                'BusinessName' => $loan->user->company->name ?? 'OCH TEST DUMMY',
                'BusinessRegistrationNumber' =>"",
                'Accountnumber' => "",
                'ProductID' => $product->bureau_product_id,
            ];
        }

        //Get Feedback From First Central
        $feedback = Http::withOptions(['verify' => false,])->post( $route, $body);

        $test = json_decode($feedback);

        //Create new Credit Score
        $credit_score = CreditScore::create([
            'loan_id' => $request->input('loan_id'), 
            'credit_score' => $test->score ?? 'No Credit Score Returned', 
            'product_id' => $request->input('product_id'), 
            'response' => $feedback, 
            'created_by' => auth('api')->id(), 
            'updated_by' => auth('api')->id(),
        ]);
        
        return response()->json([
            'credit_score' => $credit_score,
        ]);
    }
}
