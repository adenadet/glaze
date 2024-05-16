<?php
namespace App\Http\Traits;

use App\Models\Finance\AllBank;
use Illuminate\Support\Facades\Http;

use App\Models\Log\Activity;

trait PericulumTrait{
    public function periculum_bvn_verification($request){
        $feedback = Http::withOptions(['verify' => false])->withToken($request->input('token'))
        ->withOptions(['verify' => false])
        ->post(config('app.periculum_url').'/verify/bvn', [
            "statementKey" => 1, 
            "bvn" => 22168282056,
        ]);
        return $feedback;
    }

    public function periculum_nin_verification(){
        $feedback = Http::withOptions(['verify' => false])->withToken(config('app.periculum_client_strain'))
        ->withOptions(['verify' => false])
        ->post(config('app.periculum_url').'/verify/nin', [
            "statementKey" => 1, 
            "nin" => $request->nin ?? 66157865385,
        ]);
        return $feedback;
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