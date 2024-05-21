<?php
namespace App\Http\Traits;

use App\Models\Finance\AllBank;
use Illuminate\Support\Facades\Http;

use App\Models\Log\Activity;

trait PericulumTrait{
    public function periculum_bvn_verification($request){
        $data = ["bvn" =>$request->input('bvn'),];
        $feedback = Http::acceptJson()->withBody(json_encode($data), 'application/json')
        ->withToken($request->input('token'))
        ->withOptions(['verify' => false])
        ->post('https://api.insights-periculum.io/verify/bvn');
        if ($feedback->status() == 200){
            $response = json_decode($feedback->body());
        }
        else{
            $response = [
                'status' => $feedback->status(),
                'message' => 'Error occurred',
            ];
        }
        return $response;
    }

    public function periculum_nin_verification($request){
        //echo $request->input('nin');
        $data = ["nin" =>$request->input('nin'),];
        $feedback = Http::acceptJson()->withBody(json_encode($data), 'application/json')
        ->withToken($request->input('token'))
        ->withOptions(['verify' => false])
        ->post('https://api.insights-periculum.io/verify/nin');
        //print_r($feedback->body());
        //echo $feedback->status(); 
        if ($feedback->status() == 200){
            $response = json_decode($feedback->body());
            //print_r($response);
        }
        else{
            $response = json_encode([
                'status' => $feedback->status(),
                'message' => 'Error occurred'
            ]);
        }
        return $response;
    }

    public function periculum_validation(){
        $feedback = Http::withOptions(['verify' => false])->asForm()->post('https://insightsb2b.auth-periculum.app/realms/prod/protocol/openid-connect/token', [
            'client_id'     => 'insights-glazecredit-api', 
            'client_secret' => 'anewSQqfl9X1eMda4OUVGUHeqbm7bQ2X',
            'grant_type'    => 'client_credentials',
        ]);
        return $feedback;
    }
}