<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log\Activity;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $role = Auth::user()->user_type; 
        dd($role);
        switch ($role) {
            case 'SuperAdmin':
                return '/admin/dashboard'; break;
            case 'staff':
                return '/staff/dashboard'; break;
            case 'patient':
                return '/patients/dashboard'; break;
            case 'doctor':
                return '/doctors/dashboard'; break; 
            case 'hospital':
                return '/hospitals/dashboard'; break; 
            default:
                return '/home'; break;
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'unique_id';
        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            Activity::create([
                'subject' => Auth::user()->first_name.' '.Auth::user()->last_name.' has successfully logged in',
                'url' => 'New Login',
                'method' => 'auth', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => Auth::user()->id,
            ]);
            if (Auth::user()->hasRole('Staff')){return redirect()->route('staff.dashboard');}
            else{return redirect()->route('home');}
        }
        else{
            Activity::create([
                'subject' => 'Unknown user has failed to log in',
                'url' => 'Login Attempt',
                'method' => 'auth', 
                'ip' => \Illuminate\Support\Facades\Request::ip(), 
                'agent' => \Illuminate\Support\Facades\Request::header('User-Agent'), 
                'user_id' => Auth::user()->id,
            ]);
            return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
        }
          
    }
}
