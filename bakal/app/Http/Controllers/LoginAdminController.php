<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    
    public function index()
    {
        return view('admins.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            
            return redirect('admins/success');
        }
    }

    public function success()
    {
        return view('admins.success');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admins/success');
    }
}
