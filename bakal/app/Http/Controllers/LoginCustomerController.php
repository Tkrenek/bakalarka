<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;

class LoginCustomerController extends Controller
{
    /**
     * Vraci pohled s formularem pro zakaznika
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
        return view('customers.login'); // vraceni pohledu
    }

    /**
     * Prihlasi zakaznika do systemu
     * @param Illuminate\Http\Request
     */
    public function login(Request $request)
    {

        // ziskani udaju z formulare
        $credentials = $request->only('login', 'password');
 
        // overenoi udaju z formulare
        if (Auth::guard('customer')->attempt($credentials)) {
            return view('customers/welcome');
        } else {
            return back()->with('error', 'Zadán chybný login nebo heslo.'); //chybove hlaseni
        }

        
    }

    /**
     * Vraci pohled po prihlaseni zakaznika
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('customers.welcome');
    }

    /**
     * Slouzi pro odhlaseni zakaznika ze systemu
     */
    public function logout()
    {
        Auth::guard('customer')->logout(); // odhlaseni
        return redirect('/');
    }
}
