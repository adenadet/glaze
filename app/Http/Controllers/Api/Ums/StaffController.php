<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
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
    use UserTrait;

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
        return $this->initial_staffs();
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
        ]);

        $user = $this->create_new_staff($request);

        return $this->initial_staffs();

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

        $staff = $this->update_staff($request, $id);
        return $this->initial_staffs();

    }

    public function destroy($id)
    {
        $staff = $this->deactivate_staff($id);
        return $this->initial_staffs();
    }

}
