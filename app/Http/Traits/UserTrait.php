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

trait UserTrait{
    public function initial_staffs(){
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'area', 'state', 'branch', 'department', 'roles'])->paginate(6),
        ]);
    }

    public function create_new_staff($request){
        $user = $this->create_new_staff($request);

        $staff = Staff::create([
            'user_id' => $user->id,
            'branch_id' => $request->input('branch_id'),
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
            'sex' => $request->input('sex'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        //Process Image
        $image_url = 'default.png';
        if (!is_null($request['image'])){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
        }

        $user->image = $image_url;
        $user->save();

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

    }
}