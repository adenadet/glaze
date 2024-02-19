<?php

namespace App\Http\Controllers\Api\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class GeminiController extends Controller
{
    public function create_loan_request(){}

    public function create_loan_payment_schedule(){}

    public function create_loan_repayment(){}
    
    public function get_account_officer(){
        //$feedback = new Client();

        $feedback = Http::post(config('app.gemini_url').'/accountofficer');
        return json_decode($feedback);
    }

    public function get_banks(){}

    public function get_customer_by_bvn($id){}

    public function get_customer_group(){}

    public function get_customer_loan_requests($id){}

    public function get_customer_loan_request($id){}

    public function get_loan_purpose(){}

    public function get_loan_repayment_methods(){}

    public function get_loan_repayment_schedule($id){}

    public function update_customer(){} 

}
