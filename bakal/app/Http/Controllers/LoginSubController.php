<?php

namespace App\Http\Controllers;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class LoginSubController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('loginodber');
    }

    public function store(Request $request)
    {

        
        $this->validate($request, [
            
            'login' => 'required',
            'password' => 'required'

        ]);

        if (!auth()->attempt($request->only('login', 'password'), $request->remember)) {
            return back()->with('status', 'invalid login');
        }

        return redirect()->route('/');
    }
}
