<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;

use App\Models\Loans\File;
class FileController extends Controller
{
    use FileTrait;
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $file_name = $this->file_upload_by_type($request->file, 'pdf', 'uploads/files', $request->loan_id);

        $loan_file = File::create([
            'description' => $request->description,
            'loan_id' => $request->loan_id,
            'file_name' => $request->file_name,
            'source' => $file_name,
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
