<?php

namespace App\Http\Controllers\Api\Servers;

use App\Http\Controllers\Controller;
use App\Http\Traits\PericulumTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PericulumController extends Controller
{
    use PericulumTrait;

    public function bvn_query(Request $request)
    {
        $feedback = $this->periculum_bvn_verification($request);
        return response()->json($feedback);
    }

    public function destroy($id)
    {
        //
    }

    public function index()
    {
        $feedback = $this->periculum_validation();
        return $feedback;
    }

    public function login()
    {
        $feedback = Http::withHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])
        ->post(config('app.periculum_url').'realms/prod/protocol/openid-connect/token', [
            'client_id' => config('app.periculum_user'),
            'password' => config('app.periculum_clientr_secret'),
            'grant_type' => 'client_credentials',
        ]);
        return json_decode($feedback);
    }

    public function nin_query(Request $request)
    {
        $feedback = $this->periculum_nin_verification($request);
        return json_decode($feedback);
    }

    public function show($id)
    {
        return "Something went wrong";
    }

    public function store(Request $request)
    {
        $feedback = $this->periculum_validation();
        return $feedback;
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function validateToken(Request $request){
        $feedback = $this->periculum_validation();
        return $feedback;
    }
}
