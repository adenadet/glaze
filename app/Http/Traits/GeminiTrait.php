<?php
namespace App\Http\Traits;

use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\GeminiCustomerGroup;
use App\Models\Ums\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Http;

trait GeminiTrait{

    public function create_customer($customer, $user){
        $feedback = Http::withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=')->post(config('app.gemini_url').'/updateCustomer', [
            "Address" => ($user->customer_address ? $user->customer_address->street.', ' : ''). (($user->customer_address && !(is_null($user->customer_address->street2))) ? $user->customer_address->street2.', ': '').($user->customer_address ?  $user->customer_address->city.', ' : '').($user->customer_address && $user->customer_address->state_id && $user->customer_address->state != null? $user->customer_address->state->name: '') ?? "", 
            "BirthDate" => $user->dob ?? "",
            "City" => $user->customer_address->city ?? "",
            "CountryCode" => $customer->employment->income ?? "",
            "CustomerID" => "0",
            "Email" => $user->email,
            "Employer" => (object)[
                "Address" => $customer->employment->address ?? "",
                "City" => $customer->employment->city ?? "",
                "EducationLevel" => $customer->employment->education_level ?? "",
                "Email" => $customer->employment->email ?? "",
                "EmployedDate" => $customer->employment->joined_at ?? "",
                "EmployerName" => $customer->employment->name ?? "",
                "EmploymentStatus" => $customer->employment->type ?? "",
                "LGACode" => 32767,
                "Landmark" => $customer->employment->landmark ?? "",
                "MonthlyIncome" => $customer->employment->income ?? "",
                "PayDay" => $customer->employment->pay_day ?? "",
                "PensionNo" => $customer->employment->pension_id ?? "",
                "SectorCode" => $customer->employment->sector_code ?? "",
                "StaffID" => $customer->employment->staff_id ?? "",
                "StateCode" => $customer->employment->state_code ?? "",
                "TaxNo" => $customer->employment->tax_id ?? "",
                "TelephoneNo" => $customer->employment->phone_number ?? ""
            ],
            "FirstName" => $user->first_name,
            "Gender" =>  $user->sex,
            "Identification" => (object)[
                "ExpiryDate" => "",
                "Identification" => "",
                "IdentificationNo" => "",
                "IssuedDate" => "",
                "OtherIdentification" => ""
            ],
            "Info" => (object)[
                "AccountNo" => "",
                "BVNo" => $user->bvn,
                "BankCode" => "",
                "ChildrenCount" => "",
                "HouseholdCount" => "",
                "LoanRepayment" => "",
                "ResidentialStatus" => ""
            ],
            "Kin" => (object)[
                "Address" => $user->next_of_kin->address ?? "",
                "City" => '',
                "Email" => $user->next_of_kin->email ?? "",
                "EmployerName" => "" ?? "",
                "KinName" => $user->next_of_kin->name ?? "",
                "LGACode" => "" ,
                "Landmark" => "",
                "PhoneNo" => $user->next_of_kin->phone  ?? "",
                "Relationship" => $user->next_of_kin->relationship ?? "",
                "StateCode" => "",
                "TitleKey" => ""
            ],
            "LGACode" => "",
            "Landmark" => "",
            "LastName" => $user->last_name,
            "MaidenName" => "",
            "MaritalStatus" => "",
            "MiddleName" => $user->other_name,
            "PhoneNo" => $user->phone ?? "",
            "ReferralCode" => "",
            "StateCode" => "",
            "Title" => ""

        ]);
    }

    public function create_loan_request(){}

    public function create_loan_payment_schedule(){}

    public function create_loan_repayment(){}
    
    public function get_account_officer(){
        $feedback = Http::get(config('app.gemini_url').'/accountofficer')->withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=');
        return json_decode($feedback);
    }

    public function get_banks(){
        $feedback = Http::withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=')-> get(config('app.gemini_url').'/banks');
        if ($feedback->status() != 200){
            $all_banks = AllBank::select('bank_code', 'bank_name')->orderBy('bank_name', 'ASC')->get();
        }
        else{
            $banks = json_decode($feedback->body());

            $all_banks = $banks->Banks;
        }
        return $all_banks;
    }

    public function get_customer($id){
        $customer = Customer::where('id', '=', $id)->with('user')->first();
        $user = User::where('id', '=', $customer->user_id)->with('next_of_kin', 'customer_accounts', 'customer_address.state', 'social_medias', 'kyc_items')->with(['area', 'state',])->first();
        $customer_details = $this->get_customer_by_bvn($customer->user->bvn)->withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=');
        if (!$customer_details){
            $customer_details = $this->create_customer($customer, $user);
        }
        
        return json_decode($customer_details);
    }

    public function get_customer_active_loan_accounts($id){
        $customer = Customer::where('unique_id', '=', $id)->first();
        $feedback = Http::get(config('app.gemini_url').'/getloanrequest/'.$id)->withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=');
        if ($feedback->status() != 200){
            $customer_group = Account::where('user_id', '=', $customer->user_id)->orderBy('created_at', 'ASC')->orderBy('status', 'DESC')->get();
        }
        else{
            $customer_group = json_decode($feedback->body());
        }
        return $customer_group;
    }

    public function get_customer_by_bvn($id){
        $feedback = Http::get(config('app.gemini_url').'/accountofficer/'.$id)->withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=');
        return json_decode($feedback);
    }

    public function get_customer_group(){
        $feedback = Http::get(config('app.gemini_url').'/customergroup')->withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=');
        if ($feedback->status() != 200){
            $customer_group = GeminiCustomerGroup::select('cust_group_code', 'cust_group_name')->orderBy('bank_name', 'ASC')->get();
        }
        else{
            $customer_group = json_decode($feedback->body());
        }
        return $customer_group;
    }

    public function get_customer_loan_requests($id){
        $customer = Customer::where('id', '=', $id)->first();
        $feedback = Http::withToken(config('app.gemini_strain'))->get(config('app.gemini_url').'/getloanrequest/'.$customer->gemini_id);
        if ($feedback->status() != 200){
            $customer_group = Account::where('user_id', '=', $customer->user_id)->orderBy('created_at', 'ASC')->orderBy('status', 'DESC')->get();
        }
        else{
            $customer_group = json_decode($feedback->body());
        }
        return $customer_group;
    }

    public function get_customer_loan_request($id){

    }

    public function get_employer_sectors(){
        $feedback = Http::withToken('yP5lnti7wDChJxwmBYz7dpbgbzGqQRG1dyvAZihesrA=')->get(config('app.gemini_url').'/sectors');
        
        if($feedback->status() != 200){
            echo $feedback->status();
            return Array();
        }
        
        $notes =  json_decode($feedback->body());
        return $notes->Sectors;
    }

    public function get_loan_purpose(){}

    public function get_loan_repayment_methods(){}

    public function get_loan_repayment_schedule($id){}

    public function update_customer(){} 


}