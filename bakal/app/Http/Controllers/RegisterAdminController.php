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
            'phone' => 'required|numeric|unique:admins',
            
            
        ]);
     

        Admin::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'birth_date' => $request->birth_date,
        ]);


        $credentials = $request->only('email', 'password');
 

        

        if (Auth::attempt($credentials)) {
            
            return redirect('admins/success');
        }

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



        $admin->name = $request->name;
        $admin->surname = $request->surname;
        $admin->birth_date = $request->birth_date;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        $admin->save();

        return view('admins.success');
        
    }

    public function change_password()
    {
        return view('admins.change_password');
    }

    public function update_password(Request $request, $id)
    {
        $admin = Admin::find($id);
        
        $this->validate($request, [
            'password_old' => 'required',
            'password' => 'required|confirmed',
            
        ]);

        if(Hash::check($request->password_old, $admin->password)) {
            $admin->password = Hash::make($request->password);
            $admin->save();
            return back();
        } else {
            return back()->with('error', 'Zadáno chybné staré heslo');
        }

    }
}
