<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class AdminController extends Controller
{

    /**
     * Vraci pohled pro registraci admina
     * @return \Illuminate\View\View
     */ 
    public function create()
    {
        return view('admins.create');
    }

    /**
     * Overi parametry z formulare
     * a ulozi do databaze udaje admina
     * 
     * @param Illuminate\Http\Request
     */ 
    public function store(Request $request)
    {

        // validace dat z formulare
        $this->validate($request, [
                'name' => 'required',
                'surname' =>'required',
                'birth_date' => 'required|date',
                'email' => 'required|email|unique:admins',
                'password' => 'required|confirmed',
                'phone' => 'required|numeric|unique:admins',  
        ]);
        
        // vytvoreni admina
        Admin::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
        ]);


        // prihlaseni admina
        $credentials = $request->only('email', 'password');
 
        // presmerovani
        return redirect('admins/success');
    }

    /**
     * Vraci pohled s formularem pro zmenu udaju admina
     * 
     * @param $id - ID admina
     * @return \Illuminate\View\View
     */ 
    public function edit($id)
    {

        $admin = Admin::Find($id); // Vyhledani admina podle jeho ID

        return view('admins.edit', [ // pohled s formularem pro upravu admina
            'admin' => $admin
        ]);
    }


    /**
     * Aktualizuje udaje v databazi o adminovi
     * @return \Illuminate\View\View
     */ 
    public function update(Request $request, $id)
    {

        $admin = Admin::Find($id); // vyhleda admina podle ID

        // aktualizuje udaje
        $admin->name = $request->name;
        $admin->surname = $request->surname;
        $admin->birth_date = $request->birth_date;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        $admin->save(); // ulozi udaje

        return view('admins.success'); // vraci pohled
        
    }

    /**
     * Vraci pohled pro upravu hesla
     * @return \Illuminate\View\View
     */ 
    public function change_password()
    {
        return view('admins.change_password'); // vraci pohled
    }

    /**
     * Zmeni heslo v databazi
     * 
     * @param Illuminate\Http\Request
     */ 
    public function update_password(Request $request, $id)
    {
        $admin = Admin::find($id);  // vyhleda admina podle ID
        
        // Overi zda jsou vyplnene potrebne udaje
        $this->validate($request, [
            'password_old' => 'required',
            'password' => 'required|confirmed',
            
        ]);

        // pokud souhlasi hesla
        if(Hash::check($request->password_old, $admin->password)) { 
            $admin->password = Hash::make($request->password); // zmenime heslo
            $admin->save(); // ulozime
            return back()->with('success', 'Heslo úspěšně změněno'); // vracime se zpet se zpravou
        } else { // pokud je zadano chybne heslo
            return back()->with('error', 'Zadáno chybné staré heslo'); // vracime se zpet s chybovym hlasenim
        }

    }
}
