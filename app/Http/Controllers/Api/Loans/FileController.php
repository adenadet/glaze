<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loans\File;
class FileController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $upload_path = "uploads/files";
        $fileName = null;
        if((is_null($request->file)) || ($request->file == "")){$file_type = null; }
        else{
            $fileName = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($upload_path), $fileName);
        }

        $data = json_decode($request->input('data'));
        $loan_file = File::create([
            'description' => $data->description,
            'loan_id' => $data->loan_id,
            'file_name' => $data->file_name,
            'source' => is_null($request->file) ? NULL : $upload_path.'/'.$fileName,
            'file_type' => 'pdf',
            'status' => 0,
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'message' => 'Successfully uploaded',
        ]);
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        $loan_file = File::where('id', '=', $id)->first();

        $loan_file->status = $request->input('status');
        $loan_file->approved_by = auth('api')->id();
        $loan_file->approved_date = date('Y-m-d H:i:s');

        $loan_file->save();

        return response()->json([
            'message' => 'Successfully updated',
        ]);
    }

    public function destroy($id)
    {
        $loan_file = File::where('id', '=', $id)->first();

        $loan_file->deleted_by = auth('api')->id();
        $loan_file->updated_by = auth('api')->id(); 
        $loan_file->deleted_at = date('Y-m-d H:i:s');

        $loan_file->save();

        return response()->json([
            'message' => 'Successfully deleted',
        ]);
         
    }
}
