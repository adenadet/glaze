<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function chats()
    {
        $params = [
            'page' => 'Customer', 'page_title' => 'Chats',
        ];
        return view('home')->with($params);
    }

    public function dashboard()
    {
        $params = [
            'page' => 'Customer', 'page_title' => 'Dashboard',
        ];
        return view('home')->with($params);
    }

    public function guarantors()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Guarantors',
        ];
        return view('home')->with($params);
    }

    public function loans()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Loans',
        ];
        return view('home')->with($params);
    }

    public function notifications()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Notifications',
        ];
        return view('home')->with($params);
    }

    public function profile()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Profile',
        ];
        return view('home')->with($params);
    }

    
    public function test()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Test Page',
        ];
        return view('home')->with($params);
    } 

    public function tickets()
    {
        $params = [
            'page' => 'Customer', 
            'page_title' => 'Tickets',
        ];
        return view('home')->with($params);
    }
}
