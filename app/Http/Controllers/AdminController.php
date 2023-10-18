<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function branches()
    {
        $params = [
            'page_title' => 'Admin / Branches',
            'page' => 'Admin',
        ];
        return view('home')->with($params);
    }

    public function dashboard()
    {
        $params = [
            'page_title' => 'Admin / Dashboard',
            'page' => 'Admin',
        ];
        return view('home')->with($params);
    }

    public function departments()
    {
        $params = [
            'page_title' => 'Admin / Departments',
            'page' => 'Admin',
        ];
        return view('home')->with($params);
    }

    public function loan_requirement_items()
    {
        $params = [
            'page' => 'Admin',
            'page_title' => 'Admin / Loan Requirement Items',
        ];
        return view('home')->with($params);
    }

    public function loan_types()
    {
        $params = [
            'page' => 'Admin',
            'page_title' => 'Admin / Loan Types',
        ];
        return view('home')->with($params);
    }

    public function profile()
    {
        $params = [
            'page_title' => 'Profile',
        ];
        return view('home')->with($params);
    }

    public function settings()
    {
        $params = [
            'page_title' => 'Admin / Settings',
            'page' => 'settings',
        ];
        return view('home')->with($params);
    }

    public function staffs()
    {
        $params = ['page' => 'Admin', 'page_title' => 'Admin / Staffs',];
        return view('home')->with($params);
    }

    public function staff_customers()
    {
        $params = [
            'page_title' => 'Staff / Customers',
        ];
        return view('home')->with($params);
    }

    public function staff_dashboard()
    {
        $params = [
            'page_title' => 'Staff / Dashboard',
        ];
        return view('home')->with($params);
    }

    public function test()
    {
        $params = [
            'page_title' => 'Test Page',
        ];
        return view('home')->with($params);
    } 

    public function tickets()
    {
        $params = [
            'page_title' => 'Tickets',
        ];
        return view('home')->with($params);
    }

    public function users()
    {
        $params = [
            'page_title' => 'Admin / Users',
        ];
        return view('home')->with($params);
    }
}
