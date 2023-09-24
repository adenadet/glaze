<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings\KYCItem;

class KYCItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'items' => KYCitem::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'expires' => 'required|boolean',
            'files' => 'required|boolean',
        ]);

        KYCItem::create([
            'name' => $request->input('name'),
            'expires' => $request->input('expires'),
            'file' => $request->input('file'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'items' => KYCitem::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'item' => KYCitem::where('id','=', $id)->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'expires' => 'required|boolean',
            'files' => 'required|boolean',
        ]);


        $item = KYCItem::where('id', '=', $id)->first();
        
        $item->name = $request->input('name');
        $item->expires = $request->input('expires');
        $item->file = $request->input('file');
        $item->created_by = auth('api')->id();
        $item->updated_by = auth('api')->id();
        
        $item->save();

        return response()->json([
            'items' => KYCitem::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function destroy($id)
    {
        $item = KYCItem::where('id', '=', $id)->first();
        
        $item->deleted_by = auth('api')->id();
        $item->deleted_at = date('Y-m-d H:i:s');

        $item->save();

        return response()->json([
            'items' => KYCitem::orderBy('name', 'ASC')->get(),
        ]);
    }
}
