<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\CPMModule;
use App\Models\Loans\Type;
use Illuminate\Http\Request;

class CPMModuleController extends Controller
{
    public function index()
    {
        return response()->json([
            'modules' => CPMModule::orderBy('name', 'ASC')->with(['creator','templates'])->paginate(10),
            'loan_types' => Type::get(),
        ]);
    }

    public function store(Request $request)
    {
        CPMModule::create([
            'name' => $request->input('name'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);
        return response()->json([
            'modules' => CPMModule::orderBy('name', 'ASC')->paginate(10),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'modules' => CPMModule::where('id', '=', $id)->with('templates')->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $module = CPMModule::where('id', '=', $id)->first();

        $module->name = $request->input('name');
        $module->updated_by = auth('api')->id();
        
        $module->save();

        return response()->json([
            'modules' => CPMModule::orderBy('name', 'ASC')->paginate(10),
        ]);
    }

    public function destroy($id)
    {
        $module = CPMModule::where('id', '=', $id)->first();

        $module->deleted_at = date('Y-m-d H:i:s');
        $module->deleted_by = auth('api')->id();

        $module->save();

        return response()->json([
            'modules' => CPMModule::orderBy('name', 'ASC')->paginate(10),
        ]);
    }
}
