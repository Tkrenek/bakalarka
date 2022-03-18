<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class RegisterAdminController extends Controller
{
    public function index()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {

    $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'birth_date' => 'required|date',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
            'login' => 'required|unique:admins',
            'phone' => 'required|numeric|unique:admins',
            
            
        ]);
     

        Admin::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'login' => $request->login,
            'birth_date' => $request->birth_date,
        ]);
/*
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('containers.index');
        }
*/
        return back();
    }

    public function edit($id)
    {

        $admin = Admin::Find($id);

        return view('admins.edit', [
            'admin' => $admin
        ]);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::Find($id);


        $this->validate($request, [
            
        ]);


        $admin->name = $request->name;
        $admin->surname = $request->surname;
        $admin->birth_date = $request->birth_date;
        $admin->email = $request->email;
        $admin->login = $request->login;
        $admin->phone = $request->phone;

        $admin->save();

        return view('admins.success');
        
    }
}
