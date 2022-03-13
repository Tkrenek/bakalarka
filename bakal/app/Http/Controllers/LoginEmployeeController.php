<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;

class LoginEmployeeController extends Controller
{
    public function index()
    {
        return view('employees.login');
    }

    public function login(Request $request)
    {
        
 
        $credentials = $request->only('email', 'password');
 
        if (Auth::guard('employee')->attempt($credentials)) {
            
            return view('employees/welcome');
        }

        
    }

    public function welcome()
    {
        return view('employees.welcome');
    }

    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect('employees/login');
    }
}
