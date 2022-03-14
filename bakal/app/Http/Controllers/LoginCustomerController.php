<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;

class LoginCustomerController extends Controller
{
    public function index()
    {
        return view('subscribers.login');
    }

    public function login(Request $request)
    {
        
 
        $credentials = $request->only('login', 'password');
 
        if (Auth::guard('subscriber')->attempt($credentials)) {
            
            return view('subscribers/welcome');
        } else {
            return back()->with('error', 'Zadán chybný login nebo email.');
        }

        
    }

    public function welcome()
    {
        return view('subscribers.welcome');
    }

    public function logout()
    {
        Auth::guard('subscriber')->logout();
        return redirect('subscribers/login');
    }
}
