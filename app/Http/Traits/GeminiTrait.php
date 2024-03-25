<?php
namespace App\Http\Traits;

use App\Models\Area;
use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\GeminiCustomerGroup;
use App\Models\Loans\Type;
use App\Models\Ums\Customer;
use App\Models\State;
use App\Models\User;

use Illuminate\Support\Facades\Http;

trait GeminiTrait{

    public function create_gemini_customer($customer, $user){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->post(config('app.gemini_url').'/updateCustomer', [
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
        $response = json_decode($feedback->body());
        $customer->gemini_id = $response->CustomerID;

        $customer->save();
    }

    public function create_gemini_loan_request($loan){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->post(config('app.gemini_url').'/loanRequest', [
            "AccountOfficer" => "String content",
            "Amount" => $loan->amount,
            "BankAccountNo" => $laon->bank->bank_code,
            "BankCode" => $loan->bank->gemini_code,
            "ContractType" => "New",
            "CurrencyCode" => "NGN",
            "CustomerID" => $loan->customer->gemini_id,
            "LNAccountNo" =>"",
            "MangtFeeMode" => 2147483647,
            "MangtFeeRate" => "String content",
            "ProductCode" => "String content",
            "PurposeKey" => "String content",
            "RepayKey" => "String content",
            /*"Repayment" => {
                "ExpectedDate" => "String content",
                "InterestAmount" => "String content",
                "MangtFeeAmount" => "String content",
                "PrincipalAmount"=>"String content"
            },*/
            "Tenor" => "String content"
        ]);
        return json_decode($feedback);
    }

    public function create_gemini_loan_payment_schedule(){}

    public function create_gemini_loan_repayment(){}
    
    public function get_gemini_account_officers(){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/accountofficer');
        return json_decode($feedback);
    }

    public function get_gemini_banks(){
        $feedback = Http::withOptions(['verify' => false])->withToken(config('app.gemini_strain'))->get(config('app.gemini_url').'/banks');
        if ($feedback->status() != 200){
            $all_banks = AllBank::select('bank_code', 'bank_name')->orderBy('bank_name', 'ASC')->get();
        }
        else{
            $banks = json_decode($feedback->body());

            $all_banks = $banks->Banks;
        }
        return $all_banks;
    }

    public function get_gemini_customer($id){
        $customer = Customer::where('id', '=', $id)->with('user')->first();
        $user = User::where('id', '=', $customer->user_id)->with('next_of_kin', 'customer_accounts', 'customer_address.state', 'social_medias', 'kyc_items')->with(['area', 'state',])->first();
        $customer_details = $this->get_customer_by_bvn($customer->user->bvn);
        if (!$customer_details){
            $customer_details = $this->create_customer($customer, $user);
        }
        
        return json_decode($customer_details);
    }

    public function get_gemini_customer_active_loan_accounts($id){
        $customer = Customer::where('unique_id', '=', $id)->first();
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/getloanrequest/'.$id);
        if ($feedback->status() != 200){
            $customer_group = Account::where('user_id', '=', $customer->user_id)->orderBy('created_at', 'ASC')->orderBy('status', 'DESC')->get();
        }
        else{
            $customer_group = json_decode($feedback->body());
        }
        return $customer_group;
    }

    public function get_gemini_customer_by_bvn($id){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/accountofficer/'.$id);
        return json_decode($feedback);
    }

    public function get_gemini_customer_group(){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/customergroup');
        if ($feedback->status() != 200){
            $customer_group = GeminiCustomerGroup::select('cust_group_code', 'cust_group_name')->orderBy('bank_name', 'ASC')->get();
        }
        else{
            $customer_group = json_decode($feedback->body());
        }
        return $customer_group;
    }

    public function get_gemini_customer_loan_requests($id){
        $customer = Customer::where('id', '=', $id)->first();
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/getloanrequest/'.$customer->gemini_id);
        if ($feedback->status() != 200){
            $customer_accounts = Account::where('user_id', '=', $customer->user_id)->orderBy('created_at', 'ASC')->orderBy('status', 'DESC')->get();
        }
        else{
            $customer_requests = json_decode($feedback->body());
            $customer_accounts = $customer_requests->StatusList->LNStatus;
        }
        return $customer_accounts;
    }

    public function get_gemini_customer_loan_request($id){
        $customer = Customer::where('id', '=', $id)->first();
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/getloanrequest/'.$customer->gemini_id);
        return json_decode($feedback);
    }

    public function get_gemini_employer_sectors(){
        $feedback = Http::withToken(config('app.gemini_strain'))->withOptions(['verify' => false])->get(config('app.gemini_url').'/sectors');
        
        if($feedback->status() != 200){
            echo $feedback->status();
            return Array();
        }
        
        $notes =  json_decode($feedback->body());
        return $notes->Sectors;
    }

    public function get_gemini_lgas($id){
        $feedback = Http::withOptions(['verify' => false])->withToken(config('app.gemini_strain'))->get(config('app.gemini_url').'/lga/{$id}');

        if($feedback->status() != 200){
            $state_id = State::where('StateCode', '=', $id)->first()->pluck('id');
            return Area::where('state_id', '=', $state_id)->select('LGAName', 'LGANo')->get();
        }
        else{
            $notes =  json_decode($feedback->body());
            if (count($notes->LGAs) == 0){
                $state = State::select('id')->where('StateCode', '=', $id)->first();
                if($state){
                    return Area::where('state_id', '=', $state->id)->select('LGAName', 'LGANo')->get(); 
                }
                else{
                    return Area::select('LGAName', 'LGANo')->get(); 
                }
            }
            else{
                return $notes->LGAs;
            }
        }
    }

    public function get_gemini_loan_products(){
        $feedback = Http::withOptions(['verify' => false])->withToken(config('app.gemini_strain'))->get(config('app.gemini_url').'/loanproducts');
        
        if($feedback->status() != 200){
            return Type::where('status', '1')->with('requirements')->get();
        }

        $notes =  json_decode($feedback->body());
        return $notes->LNProds;
    }

    public function get_gemini_loan_purpose(){}

    public function get_gemini_loan_repayment_methods(){}

    public function get_gemini_loan_repayment_schedule($id){}

    public function get_gemini_states(){
        $feedback = Http::withOptions(['verify' => false])->withToken(config('app.gemini_strain'))->get(config('app.gemini_url').'/states');
        
        if ($feedback->status() != 200){
            return State::where('status', '=', 1)->select('StateName', 'StateCode')->get();
        }

        $notes = json_decode($feedback->body());
        return $notes->States;
    }

    public function update_gemini_customer(){} 


}