<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Http\Traits\ConfigTrait;
use App\Http\Traits\UserTrait;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Ums\Staff;
use App\Models\User;

class DepartmentController extends Controller
{
    use ConfigTrait, UserTrait;

    public function index()
    {
        return response()->json([
            'departments' => $this->initial_departments(),          
        ]);        
    }

    public function initials()
    {
        return response()->json([
            'staffs' => $this->all_staffs(),         
        ]);        
    }

    public function store(Request $request)
    {
        Department::create([
            'name' => $request->input('name'),
            'description' => $request->input('description') ?? '',
            'hod_id' => $request->input('hod_id'),
            'ext' => $request->input('ext'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'departments' => $this->initial_departments(),           
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'department' => Department::where('id', '=', $id)->with('users')->with('hod')->orderBy('name', 'ASC')->first(),           
        ]);
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        $department->name        = $request->input('name');
        $department->description = $request->input('description') ?? '';
        $department->hod_id      = $request->input('hod_id');
        $department->ext         = $request->input('ext');
        $department->email       = $request->input('email');

        $department->save();

        return response()->json([
            'departments' => $this->initial_departments(),          
        ]);
    }

    public function destroy($id)
    {
        $users = Staff::where('department_id', '=', $id)->get();
        if ((count($users) != 0) && (!is_null($users))){
            foreach ($users as $user){
                $user->department_id = null;
                $user->save();
            }
        }
        $department = Department::find($id);
        $department->deleted_by = auth('api')->id();
        $department->deleted_at = date('Y-m-d H:i:s');
        $department->save();

        return response()->json([
            'departments' => $this->initial_departments(),            
        ]); 
    }
}