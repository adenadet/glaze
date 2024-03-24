<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Mail;

use App\Http\Traits\LogTrait;

use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\Finance\BureauProduct;
use App\Models\Loans\Account;
use App\Models\Loans\CreditScore;
use App\Models\User;

trait FirstCentralTrait{
    use LogTrait;

    public function first_central_login(){
        $feedback = Http::withOptions(['debug' => true, 'verify' => false,])
        ->post(config('app.first_central_url').'/login', [
            'username' => config('app.first_central_user'),
            'password' => config('app.first_central_password')
        ]);
        return json_decode($feedback);
    }

    public function first_central_get_credit_score(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric',
            'loan_id' => 'required|numeric',
        ]);
        
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

    public function first_central_validate_token($token){
        $route = config('app.first_central_url').'/ValidateTicket';
        $feedback = Http::withOptions(['verify' => false,])->post($route, [
            'DataTicket' => $token,
        ]);
        return json_decode($feedback);
    }
}