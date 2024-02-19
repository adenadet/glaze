<?php
namespace App\Http\Traits;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\GeminiCustomerGroup;
use App\Models\State;
use App\Models\Ums\Customer;
use App\Models\Ums\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Http;


trait ConfigTrait{
    public function initial_departments(){
        return $departments =  Department::with(['staffs', 'hod'])->orderBy('name', 'ASC')->paginate(10);
    }
}