<?php
namespace App\Http\Traits;
use App\Http\Traits\FileTrait;
use App\Http\Traits\GeminiTrait;
use App\Models\Area;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Finance\AllBank;
use App\Models\Loans\Account;
use App\Models\Loans\GeminiCustomerGroup;
use App\Models\State;
use App\Models\Ums\Customer;
use App\Models\Ums\CustomerAddress;
use App\Models\Ums\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Http;

trait UserTrait{
    use FileTrait, GeminiTrait;

    public function all_staffs(){
        return Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'branch', 'department', 'roles'])->get();
    }

    public function initial_staffs(){
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'area', 'state', 'branch', 'department', 'roles'])->paginate(15),
        ]);
    }

    public function create_new_staff($request){
        $user = $this->create_new_user($request);
        $user->assignRole('Staff');
        $staff = Staff::create([
            'user_id' => $user->id,
            'unique_id' => $request->input('unique_id'),
            'branch_id' => $request->input('branch_id'),
            'department_id' => $request->input('department_id'),
            'street' => $request->input('street'),
            'street2' => $request->input('street2'),
            'city' => $request->input('city'),
            'area_id' => $request->input('area_id'),
            'state_id' => $request->input('state_id'),
            'nation_id' => $request->input('nation_id'),
            'alt_phone' => $request->input('alt_phone'),
            'joined_at' => $request->input('joined_at') ?? date('Y-m-d'),
            'personal_email' => $request->input('personal_email'),
            'marital_status' => $request->input('marital_status') ?? NULL,
        ]);

        return $staff;
    }

    public function create_new_user($request){
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name') ?? NULL,
            'bvn' => $request->input('bvn') ?? 12345678901,
            'nin' => $request->input('nin') ?? 12345678901,
            'image' => 'default.png',
            'sex' => $request->input('sex'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        //Process Image
        if (!is_null($request->input('image'))){ 
            $image = $this->file_upload_user_profile_image($request->input('image'), $user->id, 'img/profile'); 
            $user->image = $image;
            $user->save();    
        }

        return $user;
    }

    public function deactivate_staff($id){
        $staff = Staff::where('id', '=', $id)->first();

        $user = User::where('id', '=', $staff->user_id)->first();
        $user->removeRole('Staff');

        $staff->deleted_by = auth('api')->id();
        $staff->deleted_at = date('Y-m-d H:i:s');

        $staff->save();
    }

    public function update_staff($request, $id){
        $staff = Staff::where('id', '=', $id)->first();

        $user = $this->update_user($request, $staff->user_id);

        $staff->branch_id = $request->input('branch_id');
        $staff->street = $request->input('street');
        $staff->street2 = $request->input('street2');
        $staff->city = $request->input('city');
        $staff->area_id = $request->input('area_id');
        $staff->state_id = $request->input('state_id');
        $staff->nation_id = $request->input('nation_id');
        $staff->alt_phone = $request->input('alt_phone');
        $staff->joined_at = $request->input('joined_at') ?? date('Y-m-d');
        $staff->personal_email = $request->input('personal_email');
        $staff->marital_status = $request->input('marital_status') ?? NULL;
        
        $staff->save();

        return $staff;
    }

    public function update_user($request, $id){
        $user = User::where('id', '=', $id)->first();

        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->unique_id = $request->input('unique_id');
        $user->bvn = $request->input('bvn');
        $user->nin = $request->input('nin');
        $user->sex = $request->input('sex');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob'); 

        $user->save();

        return $user;
    }

    public function user_create_customer_from_user($request, $user){
        $user = is_null($user) ? $this->create_new_user($request): $user;

        $user->assignRole('Customer');
        $this->create_gemini_customer($customer, $user);

        Activity::create([
            'subject' => $user->first_name.' '.$user->last_name.' has successfully registered',
            'url' => 'New Registration',
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user->id,
        ]);
    }

    public function user_address_create_new($request){

        $state = State::where('StateCode', '=', $request->input('state_id'))->first();

        $customer_address = CustomerAddress::create([
            'user_id' => $request->input('user_id'),
            'type' => $request->input('type'),
            'street' => $request->input('street'),
            'street_2' => $request->input('street2'),
            'city' => $request->input('city'),
            'state_id' => $state->id,
            'area_id' => $request->input('area_id'),
            'status' => $request->input('status') ?? 0,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return $customer_address;
    }

    public function user_address_update($request, $id){
        $state = State::where('StateCode', '=', $request->input('state_id'))->first();
        $customer_address = CustomerAddress::where('id', '=', $id)->first();

        $customer_address->user_id = $request->input('user_id');
        $customer_address->type = $request->input('type');
        $customer_address->street = $request->input('street');
        $customer_address->street_2 = $request->input('street2');
        $customer_address->city = $request->input('city');
        $customer_address->state_id = $state->id;
        $customer_address->area_id = $request->input('area_id');
        $customer_address->status = $request->input('status') ?? 0;
        $customer_address->updated_by = auth('api')->id();
        
        $customer_address->save();

        return $customer_address;

    } 
    
    public function user_get_by_id($id, $detailed){
        $query = User::where('id', '=', $id);

        if ($detailed){
            $query = $query->with(['customer', 'staff']);
        }

        $user = $query->first();

        return $user;
    }

    public function user_get_customer_by_user_id($id){
        $user = User::where('id', '=', $id)->with(['customer'])->first();

        return $user;
    }
}