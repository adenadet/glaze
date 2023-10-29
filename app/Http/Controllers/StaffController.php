<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function accounts()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Accounts',
        ];
        return view('home')->with($params);
    }

    public function confirmations()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Confirmations',
        ];
        return view('home')->with($params);
    }

    public function chats()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Chats',
        ];
        return view('home')->with($params);
    }

    public function dashboard()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Dashboard',
        ];
        return view('home')->with($params);
    }

    public function customers()
    {
        $params = ['page' => 'Staff', 'page_title' => 'Customers',];
        return view('home')->with($params);
    }

    public function loans()
    {
        $params = ['page' => 'Staff', 'page_title' => 'Staff Loans',];
        return view('home')->with($params);
    }

    public function profile()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Profile',
        ];
        return view('home')->with($params);
    }

    public function staff_customers()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Staff Customers',
        ];
        return view('home')->with($params);
    }

    public function staff_dashboard()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Staff Dashboard',
        ];
        return view('home')->with($params);
    }

    public function test()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Test Page',
        ];
        return view('home')->with($params);
    } 

    public function tickets()
    {
        $params = [
            'page' => 'Staff', 'page_title' => 'Tickets',
        ];
        return view('home')->with($params);
    }
}
