<?php

namespace App\Http\Controllers\EMR;

use App\Http\Controllers\Controller;
use App\Models\EMR\Appointment;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function administrator()
    {
        $params = [
            'page_title' => 'E-Services | Administrator',
        ];
        return view('eservices')->with($params);
    }

    public function certificate()
    {
        $params = [
            'page_title' => 'E-Services | Certificate',
        ];
        return view('eservices')->with($params);
    }

    public function consent($id)
    {
        $appointment = Appointment::where('id', '=', $id)->with(['front_officer', 'service', 'patient.nationality', 'consent' ])->first();

        $params = [
            'page_title' => 'E-Services | Consent Form',
            'appointment' => $appointment,
        ];
        return view('consent')->with($params);
    }

    public function front()
    {
        $params = [
            'page_title' => 'E-Services | Front Office',
        ];
        return view('eservices')->with($params);
    }

    public function front_admin()
    {
        $params = [
            'page_title' => 'E-Services | Front Admin',
        ];
        return view('eservices')->with($params);
    }

    public function medical()
    {
        $params = [
            'page_title' => 'E-Services | Medical Officer',
        ];
        return view('eservices')->with($params);
    }

    public function radiologist()
    {
        $params = [
            'page_title' => 'E-Services | Radiologist',
        ];
        return view('eservices')->with($params);
    }
}
