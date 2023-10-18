<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Settings\KYCItem;
use App\Models\Ums\UserKYC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KYCController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric',
            'kyc_items' => 'required|array',
        ]);

        //print_r($request->input('kyc_items'));
        $folder = 'uploads/kyc/';
        $file_name = ''; 
        
        foreach ($request->input('kyc_items') as $kyc){
            if ($kyc['kyc_file_type'] == "Image"){
                $name = $request->input('user_id')."-".$kyc['name'].time().".".explode('/',explode(':', substr( $kyc['kyc_file'], 0, strpos($kyc['kyc_file'], ';')))[1])[1];
                \Image::make($kyc['kyc_file'])->save(public_path($folder).$name);
                $file_name = 'uploads/kyc/'.$name;
            }
            else if($kyc['kyc_file_type'] == "PDF"){
                if (strpos($kyc['kyc_file'], ',') !== false) {
                    @list($encode, $kyc['kyc_file']) = explode(',', $kyc['kyc_file']);
                }
        
                $base64data = base64_decode($kyc['kyc_file'], true);
                $file_name = $request->input('user_id')."-".$kyc['name'].time().".".strtolower($kyc['kyc_file_type']);
                
                $file_path  = "{$folder}{$file_name}";
        
                // Return the number of bytes saved, or false on failure
                $result = file_put_contents("{$file_path}", $base64data);
            }
            else{
                $file_name = NULL;
            }

            echo $file_name;
            UserKYC::create([
                'user_id' => $request->input('user_id'),
                'item_id' => $kyc['id'],
                'file' => $file_name,
                'identification' => $kyc['identification'] ?? NULL,
                'expiry_date' => $kyc['expiry_date'] ?? NULL,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]);
        }

        return response()->json([
            
        ]);
    }

    public function show($id)
    {
        $user_kyc_items = KYCItem::select( 'setting_kyc_items.*', 
            DB::raw('(select file from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.$id.' order by id asc limit 1) as kyc_file'),
            DB::raw('(select identification from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.$id.' order by id asc limit 1) as kyc_identification'),
            DB::raw('(select expiry_date from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.$id.' order by id asc limit 1) as kyc_expiry_date'),
            DB::raw('(select type from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.$id.' order by id asc limit 1) as kyc_type'),
        )->get();

        return response()->json([
            'user_kyc_items' => $user_kyc_items,
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
