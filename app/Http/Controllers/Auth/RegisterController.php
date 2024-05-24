<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeminiTrait;
use App\Http\Traits\UserTrait;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Finance\Wallet;
use App\Models\Log\Activity;
use App\Models\Ums\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use GeminiTrait, RegistersUsers, UserTrait;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8',],
            'phone'         => ['required', 'numeric', 'min:10',],
            'bvn'           => ['required', 'numeric', 'min:11',],
            'nin'           => ['required', 'numeric', 'min:11',],
        ]);
    }

    protected function create(array $data)
    {
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'bvn' => $data['bvn'],
            'nin' => $data['nin'],
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
            'status' => 1,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        
        $user->assignRole('Customer');
        $this->create_gemini_customer($customer, $user);

        Activity::create([
            'subject' => $user->first_name.' '.$user->last_name.' has successfully registered',
            'url' => 'New Registration',
            'method' => 'create', 
            'ip' => \Illuminate\Support\Facades\Request::ip(), 
            'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
            'user_id' => $user->id,
        ]);

        return $user;
        
    }
}
