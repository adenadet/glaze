<?php

namespace Tests\Feature\Loans;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

class CreateLoanTest extends TestCase
{
    public function test_check_database_loans_table_is_empty(){
        $this->assertDatabaseMissing('loan_accounts', [
            'id' => 1
        ]);
    }

    public function test_create_a_new_business_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/loans/accounts', [
            'loan_type_id' => '201',
            'amount'=> '300000',
            'duration'=> '6',
            'bank_id' => '011',
            'acct_name' => 'Adeniyi Adetunji',
            'acct_number' => '0123456789',
            'frequency' => 'monthly',
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function test_create_a_new_personal_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/loans/accounts', [
            'loan_type_id' => '200',
            'amount'=> '300000',
            'duration'=> '6',
            'bank_id' => '011',
            'acct_name' => 'Adeniyi Adetunji',
            'acct_number' => '0123456789',
            'frequency' => 'monthly',
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function test_create_a_new_staff_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/loans/accounts', [
            'loan_type_id' => '202',
            'amount'=> '300000',
            'duration'=> '6',
            'bank_id' => '011',
            'acct_name' => 'Adeniyi Adetunji',
            'acct_number' => '0123456789',
            'frequency' => 'monthly',
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function test_create_guarantor_request_for_business_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $loan = Account::where('type_id', '=', 1)->where('user_id', '=', $user->id)->latest()->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/loans/guarantors/add', [
            'loan_id' => $loan->id,
            'guarantors' => [
                [
                    'first_name'    => 'Aden',
                    'last_name'     => 'Adetunji',
                    'phone'         => '08012341234',
                    'email'         => 'adenadet01@gmail.com',
                ],
                [
                    'first_name'    => 'Adeniyi',
                    'last_name'     => 'Adetunji',
                    'phone'         => '08012345678',
                    'email'         => 'adenadet@gmail.com',
                ],
            ],
        ]);

        $this->assertEquals(200, $response->status());
    }

    public function test_create_guarantor_confirmation_for_business_loan_not_complete(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        //Get test loan
        $loan = Account::where('type_id', '=', 1)->where('user_id', '=', $user->id)->latest()->first();
        $guarantor_request = GuarantorRequest::where('loan_id', '=', $loan->id)->where('status', '=', 0)->first();
        $response = $this->json('POST', '/api/guarantor_requests', [
        //Confirm the Loan Requests
            'request_id'=> $guarantor_request->id,
            'title'=> 'Engr',
            'first_name'=> 'Adeniyi',
            'middle_name'=> 'Akinniyi',
            'last_name'=> 'Adetunji',
            'relationship'=> 'Colleague',
            'email'=> 'adenadet01@gmail.com',
            'phone'=> '07036568933',
            'employer'=> 'St. Nicholas Hospital',
            'employer_address'=> '57, Campbell Street, Lagos Island, Lagos',
            'employer_phone'=> '08012341234',
            'employer_email'=> 'aadetunji@saintnicholashospital.com',
            'marital_status'=> 'Married',
            'residential_address' => 'This is a test residential address',
            'relationship'=> 'Colleague',
            'address'=> 'This is a test residential address',
            'bvn'=> '123412341234',
            'nationality_id' => 1,
            'dob' => '1988-09-06',
            'net_income'=> '500,000 - 1,000,000',
            'guarantor_signature' => '',
            'address_proof' => NULL,
            'valid_id' => NULL,
            'passport' => NULL,
        ]);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('loan_guarantor_requests', ['id' => $guarantor_request->id, 'status' => 1,]);
        $this->assertDatabaseHas('loan_guarantors', ['request_id' => $guarantor_request->id, 'status' => 1,]);
        //$this->assertDatabaseHas('loan_accounts', ['id' => $loan->id, 'status' => 3,]);
    }

    public function test_create_guarantor_confirmation_for_personal_loan_completed(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        //Get test loan
        $loan = Account::where('type_id', '=', 1)->where('user_id', '=', $user->id)->latest()->first();
        $guarantor_request = GuarantorRequest::where('loan_id', '=', $loan->id)->where('status', '=', 0)->first();
        $response = $this->json('POST', '/api/guarantor_requests', [
        //Confirm the Loan Requests
            'request_id'=> $guarantor_request->id,
            'title'=> 'Engr',
            'first_name'=> 'Adeniyi',
            'middle_name'=> 'Akinniyi',
            'last_name'=> 'Adetunji',
            'relationship'=> 'Colleague',
            'email'=> 'adenadet01@gmail.com',
            'phone'=> '07036568933',
            'employer'=> 'St. Nicholas Hospital',
            'employer_address'=> '57, Campbell Street, Lagos Island, Lagos',
            'employer_phone'=> '08012341234',
            'employer_email'=> 'aadetunji@saintnicholashospital.com',
            'marital_status'=> 'Married',
            'residential_address' => 'This is a test residential address',
            'relationship'=> 'Colleague',
            'address'=> 'This is a test residential address',
            'bvn'=> '123412341234',
            'status'=> 1,
            'nationality_id' => 1,
            'dob' => '1988-09-06',
            'description'=> NULL,
            'net_income'=> '500,000 - 1,000,000',
            'guarantor_signature' => '',
            'address_proof' => NULL,
            'valid_id' => NULL,
            'passport' => NULL,
        ]);

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('loan_guarantor_requests', ['id' => $guarantor_request->id, 'status' => 1,]);
        $this->assertDatabaseHas('loan_guarantors', ['request_id' => $guarantor_request->id, 'status' => 1,]);
        $this->assertDatabaseHas('loan_accounts', ['id' => $loan->id, 'status' => 6,]);
    }

    /*public function test_check_loan_confirmation_process(){

    }*/

    public function test_delete_guarantor_request_for_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $loan = Account::where('type_id', '=', 1)->where('user_id', '=', $user->id)->latest()->first();
        $guarantor_requests = GuarantorRequest::where('loan_id', '=', $loan->id)->get();

        foreach ($guarantor_requests as $gr){
            $response = $this->actingAs($user, 'api')->json('DELETE', '/api/loans/guarantors/'.$gr->id);
            $this->assertDatabaseHas('loan_guarantor_requests', ['id' => $gr->id, 'deleted_by' => $user->id]);
            $this->assertDatabaseHas('loan_guarantors', ['request_id' => $gr->id, 'deleted_by' => $user->id]);
        }
    }
    
    public function test_delete_business_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $loan = Account::where('type_id', '=', 1)->where('user_id', '=', $user->id)->latest()->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/loans/accounts/'.$loan->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_delete_personal_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $loan = Account::where('type_id', '=', 3)->where('user_id', '=', $user->id)->latest()->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/loans/accounts/'.$loan->id);

        $this->assertEquals(200, $response->status());
    }

    public function test_delete_staff_loan(){
        $user = User::where('unique_id', '=', 'E0270')->first();
        $loan = Account::where('type_id', '=', 2)->where('user_id', '=', $user->id)->latest()->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/loans/accounts/'.$loan->id);

        $this->assertEquals(200, $response->status());
    }
}
