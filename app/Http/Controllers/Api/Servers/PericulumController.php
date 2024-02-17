<?php

namespace App\Http\Controllers\Api\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

class PericulumController extends Controller
{
    public function index()
    {
        /*$feedback = Http::withHeaders([
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])
        ->post(config('app.periculum_url').'realms/prod/protocol/openid-connect/token', [
            'client_id' => config('app.periculum_user'),
            'password' => config('app.periculum_clientr_secret'),
            'grant_type' => 'client_credentials',
        ]);
        return json_decode($feedback);*/

        $feedback = new Client();

        $response = $feedback->request('POST', config('app.periculum_url').'/realms/prod/protocol/openid-connect/token', [
            'headers' => ['Content-type: application/x-www-form-urlencoded'],
            'form_params' => [
                'client_id' => config('app.periculum_user'),
                'client_secret' => config('app.periculum_client_secret'),
                'grant_type' => 'client_credentials',
            ],
            'timeout' => 20, // Response timeout
            'connect_timeout' => 20, // Connection timeout
        ]);
         
        return($response->getBody()->getContents());
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


    public function bvn_query(Request $request)
    {
        $feedback = Http::withHeaders([
            'Authorization' => 'Bearer '.$request->input('et'),
            'Content-Type'  => 'application/json',
        ])
        ->accept('application/json')
        ->put('https://api.insights-periculum.com/verify/bvn', [
            'statementKey' => 1,
            'bvn' => $request->input('bvn'),
        ]);
        return json_decode($feedback);
    }

    public function validateToken(Request $request){
        $route = config('app.periculum_url').'/ValidateTicket';
        $feedback = Http::post($route, [
            'DataTicket' => $request->input('token'),
        ]);
        return json_decode($feedback);
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return "Something went wrong";
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
