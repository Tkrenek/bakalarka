<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;

class LoginEmployeeController extends Controller
{
    /**
     * Vraci pohled s formularem pro zamestnance
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // pokud se o tuto akci snazi jiz prihlaseny uzivatel je odhlasen
        if(auth('customer')->user()){
            Auth::guard('customer')->logout();
        } else if (auth('admin')->user()){
            Auth::guard('admin')->logout();
        } else if(auth('employee')->user()){
            Auth::guard('employee')->logout();
        } 
        return view('employees.login'); // vraceni pohledu
    }

    /**
     * Prihlasi zamestnance do systemu
     * @param Illuminate\Http\Request
     */
    public function login(Request $request)
    {
        // ziskani udaju z formulare
        $credentials = $request->only('email', 'password');

        // overenoi udaju z formulare
        if (Auth::guard('employee')->attempt($credentials)) {
            
            return view('employees/welcome');
        }

        return back()->with('error', 'Zadán chybný email nebo heslo');

        
    }

    /**
     * Vraci pohled po prihlaseni zamestnance
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('employees.welcome');
    }

    /**
     * Slouzi pro odhlaseni zakaznika ze systemu
     */
    public function logout()
    {
        Auth::guard('employee')->logout(); // odhlaseni
        return redirect('/');
    }
}
