<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuarantorController extends Controller
{
    public function show($id)
    {
        $params = [
            'page_title' => 'Guarantor Confirmation Page',
        ];
        return view('external')->with($params);
    }
}
