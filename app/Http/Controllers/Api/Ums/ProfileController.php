<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\NextOfKin;
use App\Models\Settings\KYCItem;
use App\Models\State;
use App\Models\Ums\SocialMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $kyc_items = KYCItem::select( 'setting_kyc_items.*', 
            DB::raw('(select file from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_file'),
            DB::raw('(select identification from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_identification'),
            DB::raw('(select expiry_date from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_expiry_date'),
            DB::raw('(select type from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_type'),
        )->get();

        return response()->json([
            'areas' => Area::select('id', 'name')->where('state_id', 25)->orderBy('name', 'ASC')->get(),
            'kyc_items' => $kyc_items,
            'kyc_list' => KYCItem::all(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->first(),
            'states' => State::orderBy('name', 'ASC')->get(),
            'socials' => SocialMedia::where('user_id', auth('api')->id())->first(),
            'user' => User::where('id', '=', auth('api')->id())->with('next_of_kin', 'customer_accounts', 'customer_address.state', 'social_medias')->with(['area', 'state',])->first(),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
