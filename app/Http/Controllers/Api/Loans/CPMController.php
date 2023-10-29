<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loans\CPM;

class CPMController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        CPM::create([
            'loan_id' => $request->input('loan_id'),
            'detail' => $request->input('detail'),
        ]);

        return response()->json([
            'cpm' => CPM::latest()->paginate(20),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'cpm' => CPM::where('loan_id', '=', $id)->first(),
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
