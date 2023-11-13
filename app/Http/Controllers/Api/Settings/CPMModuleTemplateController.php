<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\Loans\Type;
use App\Models\Settings\CPMModule;
use App\Models\Settings\CPMModuleTemplate;
use Illuminate\Http\Request;

class CPMModuleTemplateController extends Controller
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
        $template = CPMModuleTemplate::create([
            'name' => $request->input('name') ?? NULL,
            'module_id' => $request->input('module_id'),
            'loan_type_id' => $request->input('loan_type_id') ?? NULL,
            'details' => $request->input('details'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(), 
        ]);

        return response()->json([
            'template' => $template,
            'modules' => CPMModule::orderBy('name', 'ASC')->with(['creator','templates'])->paginate(10),
            'loan_types' => Type::get(),
        ]);
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        $template = CPMModuleTemplate::where('id', '=', $id)->first();

        $template->name = $request->input('name') ?? NULL;
        $template->module_id = $request->input('module_id');
        $template->loan_type_id = $request->input('loan_type_id') ?? NULL;
        $template->details = $request->input('details');
        $template->updated_by = auth('api')->id();

        $template->save();
        
        return response()->json([
            'template' => $template,
            'modules' => CPMModule::orderBy('name', 'ASC')->with(['creator','templates'])->paginate(10),
            'loan_types' => Type::get(),
        ]);
    }

    public function destroy($id)
    {
        $template = CPMModuleTemplate::where('id', '=', $id)->first();

        $template->deleted_by = auth('api')->id();
        $template->deleted_at = date('Y-m-d H:i:s');
        $template->save();

        return response()->json([
            'template' => $template,
            'modules' => CPMModule::orderBy('name', 'ASC')->with(['creator','templates'])->paginate(10),
            'loan_types' => Type::get(),
        ]);
    }
}
