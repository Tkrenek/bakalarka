<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;

class LoginCustomerController extends Controller
{
    public function index()
    {
        if(auth('customer')->user()){
            Auth::guard('customer')->logout();
     
        } else if (auth('admin')->user()){
            Auth::guard('admin')->logout();
    
        } else if(auth('employee')->user()){
            Auth::guard('employee')->logout();

        } 

        return view('customers.login');
    }

    public function login(Request $request)
    {

        
        $credentials = $request->only('login', 'password');
 
        if (Auth::guard('customer')->attempt($credentials)) {
            return view('customers/welcome');
        } else {
            return back()->with('error', 'Zadán chybný login nebo heslo.');
        }

        
    }

    public function welcome()
    {
        return view('customers.welcome');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
}
