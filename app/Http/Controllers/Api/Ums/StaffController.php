<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Department;
use App\Models\NextOfKin;
use App\Models\State;
use App\Models\User;
use App\Models\Ums\Staff;

use App\Models\EMR\Patient;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function full_list()
    {
        $all_staffs = Staff::pluck('user_id');
        if ($search = \Request::get('q')){
            $users = User::orderBy('first_name', 'ASC')->with(['staff.department'])->where(function($query) use ($search){
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('middle_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
                })->whereIn('id', $all_staffs)->get();
            }
        else{
            $users = User::orderBy('first_name', 'ASC')->with(['staff.department'])->whereIn('id', $all_staffs)->get();
        }
        return response()->json([
            'users' => $users,
        ]);
    }

    public function index($page = 1)
    {        
        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'area', 'state', 'branch', 'department', 'roles'])->paginate(6),
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'branch_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'joined_at' => 'sometimes|date',
            'sex' => 'required|string',
            'dob' => 'required|date',
            //'unique_id' => 'required|unique:users',
        ]);

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

        //Send Staff New Mail to personal email and send to email

        //Process Image
        $image_url = 'default.png';
        if (!is_null($request['image'])){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];
            \Image::make($request['image'])->save(public_path('img/profile/').$image);
            $image_url = $image;
        }

        $user->image = $image_url;
        $user->save();

        $user->syncRoles($request->input('roles'));

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'area', 'state', 'branch', 'department', 'roles'])->paginate(6),
        ]);

    }

    public function show($id)
    {
        return response()->json([
            'staff' => Staff::where('id', '=', $id)->with(['user', 'branch', 'department'])->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'sometimes',
            'street2' => 'sometimes',
            'city' => 'required',
            'state_id' => 'numeric',
            'area_id' => 'numeric',
            'phone' => 'numeric',
            'alt_phone' => 'nullable|numeric',
            'branch_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'joined_at' => 'sometimes|date',
            'sex' => 'required|string',
            'dob' => 'required|date',
        ]);

        $staff = Staff::where('id', '=', $id)->first();
        $user = User::where('id', '=', $staff->user_id)->first();
        
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->middle_name = $request->input('middle_name') ?? NULL;
        $user->bvn = $request->input('bvn') ?? 12345678901;
        $user->sex = $request->input('sex');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        $user->email = $request->input('email');
        
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

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'branches' => Branch::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'departments' => Department::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'states' => State::orderBy('name', 'ASC')->get(),       
            'users' => Staff::orderBy('unique_id', 'ASC')->with(['user.roles', 'area', 'state', 'branch', 'department', 'roles'])->paginate(6),
        ]);
    }

    public function destroy($id)
    {
        //
    }

}
