<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Models\Ums\SocialMedia;
use App\Models\User;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {

        SocialMedia::create([
            'user_id' => $request->input('user_id'),
            'facebook_url' => $request->input('facebook_url'),
            'twitter_url' => $request->input('twitter_url'),
            'linkedin_url' => $request->input('linkedin_url'),
            'instagram_url' => $request->input('instagram_url'),
            'created_by' => auth('api')->id(),
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $social_media = SocialMedia::where('id', '=', $id)->first();

        $social_media->user_id = $request->input('user_id');
        $social_media->facebook_url = $request->input('facebook_url');
        $social_media->twitter_url = $request->input('twitter_url');
        $social_media->linkedin_url = $request->input('linkedin_url');
        $social_media->instagram_url = $request->input('instagram_url');
        $social_media->updated_by = auth('api')->id();

        $social_media->save();

        return response()->json([
            'user' => User::where('id', '=', $request->input('user_id'))->with('next_of_kin', 'customer_accounts', 'customer_addresses', 'social_medias', 'customer_kyc')->with(['area', 'state',])->get(),
        ]);

    }

    public function destroy($id)
    {
        //
    }
}
