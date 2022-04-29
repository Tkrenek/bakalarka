<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    
    /**
     * Vraci pohled s formularem pro admina
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // pokud se o tuto akci snazi jiz prihlaseny uzivatel je odhlasens
        if(auth('customer')->user()){
            Auth::guard('customer')->logout();
     
        } else if (auth('admin')->user()){
            Auth::guard('admin')->logout();
    
        } else if(auth('employee')->user()){
            Auth::guard('employee')->logout();

        } 
        return view('admins.login'); // vceni pohledu
    }

     /**
     * Prihlasi admina do systemu
     * @param Illuminate\Http\Request
     */
    public function login(Request $request)
    {

        // ziskani udaju z formulare
        $credentials = $request->only('email', 'password');
      
        // overenoi udaju z formulare
        if (Auth::guard('admin')->attempt($credentials)) {
            return view('admins/success');
        } else {
            return back()->with('error', 'Zadán chybný email nebo heslo.'); //chybove hlaseni
        }   
    }

    /**
     * Vraci pohled po prihlaseni admina
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('admins.success');
    }

    /**
     * Slouzi pro odhlaseni admina ze systemu
     */
    public function logout()
    {
        Auth::guard('admin')->logout(); // odhlaseni
        return redirect('/'); 
    }
}
