<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use App\Models\Loans\Account;
use App\Models\Loans\ConfirmationAction;
use App\Models\Loans\ConfirmationMatrix;
use App\Models\Loans\ConfirmationMatrixItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmationController extends Controller
{
    public function index()
    {
        $roles = DB::table('model_has_roles')->where('model_id','=', 1)->pluck('role_id');
        $matrix = ConfirmationMatrix::pluck('id');
        
        $matrixes = [];

        for ($i = 0; $i < count($matrix); $i++){
            
            $matrix_levels = [
                'matrix_id' => $matrix[$i],
                'status' => ConfirmationMatrixItem::whereIn('role_id', $roles)->pluck('stage_number')
            ];

            array_push($matrixes, $matrix_levels);
        }

        return response()->json([
            'roles' => $roles,
            'matrixes' => $matrixes,
            //'account' => $loan,
            //'actions' => ConfirmationAction::where('loan_id', '=', $request->input('loan_id'))->orderBy('created_at', 'DESC')->with([])->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'loan_id' => 'required|numeric', 
            'action' => 'required|numeric', 
            'description' => 'sometimes', 
            'start_stage' => 'required|numeric', 
            'end_stage' => 'required|numeric',
        ]);

        $loan = Account::where('id', '=', $request->input('loan_id'))->with('type.matrix')->first();
        $start_point = ConfirmationMatrixItem::select('role_id')->where('stage_number', '=', $request->input('start_stage'))->where('matrix_id', '=', $loan->type->matrix->id)->with('role')->first();
        $end_point = ConfirmationMatrixItem::select('role_id')->where('stage_number', '=', $request->input('end_stage'))->where('matrix_id', '=', $loan->type->matrix->id)->with('role')->first();

        $action = ConfirmationAction::create([
            'loan_id' => $request->input('loan_id'),
            'action'  => $request->input('action'),
            'summary' => 'from '.$start_point->role->name.' to '.$end_point->role->name,
            'description' => $request->input('description'),
            'start_stage' => $request->input('start_stage'),
            'end_stage'=>$request->input('end_stage'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'account' => $loan,
            'actions' => ConfirmationAction::where('loan_id', '=', $request->input('loan_id'))->orderBy('created_at', 'DESC')->with([])->paginate(20),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'account' => Account::where('id', '=', $id)->with('type.matrix')->first(),
            'actions' => ConfirmationAction::where('loan_id', '=', $id)->orderBy('created_at', 'DESC')->with([])->paginate(20),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
