<?php

namespace App\Http\Controllers\Api\Loans;

use App\Http\Controllers\Controller;
use App\Models\Finance\Bureau;
use App\Models\Finance\BureauProduct;
use App\Models\Loans\Account;
use App\Models\Loans\CreditScore;
use Illuminate\Http\Request;

class CreditScoreController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return response()->json([
            'account' => Account ::where('id', '=', $id)->with(['repayments', 'user'])->first(),
            'bureaus' => Bureau ::select('id', 'name', 'link')->orderBy('name', 'ASC')->get(),
            'bureau_products' => BureauProduct ::orderBy('name', 'ASC')->get(),
            'credit_scores' => CreditScore ::where('loan_id', '=', $id)->with('product.bureau', 'creator')->latest()->paginate(4),
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
