<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;


class CustomerController extends Controller
{
    
    /**
     * Vraci pohled se vsemi zakazniky
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customers = Customer::get(); // ulozeni vsech zakazniku do promenne

        // vraci pohled se zakazniky
        return view('customers.index',[
            'customers' => $customers
        ]);
    }

    /**
     * Vraci pohled s formulare pro vytvoreni noveho zakaznika
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('customers.register'); // vraci pohled
    }

    /**
     * Ulozi zaznam o novem zakaznikovi do databaze
     * 
     * @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required|unique:customers',
            'town' =>'required',
            'address' => 'required|unique:customers',
            'login' => 'required|unique:customers',
            'password' => 'required|confirmed',
        ]);

        // vytvoreni noveho zakaznika
        Customer::create([
            'name' => $request->name,
            'town' => $request->town,
            'address' => $request->address,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'url' => $request->url,
        ]);

        // prihlaseni zakaznika
        $credentials = $request->only('login', 'password');
 
        // pokud je prihlasen admin
        if(auth('admin')->user()) {
            return redirect()->route('customers.index'); // vracime pohled se vsemi zakazniky
        }
        //pokud si ucet vytvari zakaznik
        if (Auth::guard('customer')->attempt($credentials)) { 
            return view('customers/welcome'); // vracime uvodni obrazovku pro zakaznika
        } else {
            // pokud nastane chyba, vracime chybove hlaseni
            return back()->with('error', 'Zadán chybný login nebo heslo.');
        }

    }

    /**
     * Vraci zaznam s formularem pro upravu udaju zakaznika
     * 
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $customer = Customer::where('id', $id)->first(); // vyhleda zakaznika podle ID

        // vraci pohled pro upravu
        return view('customers.update', [
            'customer' => $customer
        ]);
    }

    /**
     * Upravi udaje zakaznika v databazi
     * 
     * @param Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required',
            'address' =>'required',
            'town' => 'required',
            'login' => 'required',
        ]);
 
        $customer = Customer::find($id); // vyhledani zakaznika podle ID

        // zmeni udaje zakaznika
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->town = $request->town;
        $customer->login = $request->login;
        $customer->url = $request->url;        

        $customer->save(); // ulozi udaje zakaznika v databazi

        if(auth('admin')->user()) { // pokud je prihlasen admin
            return redirect()->route('customers.index'); // presmerovani na stranku se zakazniky
        } else if(auth('customer')->user()) { // pokud je prihlasen zakaznik
            return redirect()->route('customers.welcome'); // presmerovani na uvodni stranku
        }
        
    }

    /**
     * Smaze zaznam o zakaznikovi z databaze
     */
    public function destroy($id)
    {

        $customer = Customer::find($id); // vyhledani zakaznika podle ID
        $customer->delete(); // smazani zakaznika 

        return back(); // navrat zpet
    }

    /**
     * Vraci pohled pro zmenu hesla zakaznika
     * 
     * @return \Illuminate\View\View
     */
    public function change_password()
    {
        return view('customers.change_password'); // vraci pohled
    }

    /**
     * Zmeni heslo zakaznika v databazi
     * 
     * @param Illuminate\Http\Request
     */
    public function update_password(Request $request, $id)
    {

        $customer = Customer::find($id); // vyhleda zakaznika v databazi podle ID
        
        // overeni udaju z formulare
        $this->validate($request, [
            'password_old' => 'required',
            'password' => 'required|confirmed',
            
        ]);

        // pokud je spravne zadane heslo
        if(Hash::check($request->password_old, $customer->password)) {
            $customer->password = Hash::make($request->password); // ulozi se nove heslo
            $customer->save();
            return back()->with('success', 'Heslo úspěšně změněno');
        } else {
            return back()->with('error', 'Zadáno chybné staré heslo'); // chybove hlaseni
        }

    }

    /**
     * Vraci pohled s formularem pro upravu hesla zakaznika
     * z role admina
     * 
     * @return \Illuminate\View\View
     */
    public function changePasswordAdmin($id)
    {
        $customer = Customer::find($id);

        return view('customers.change_passwordAdmin', [
            'customer' => $customer
        ]);
    }

    /**
     * Zmena hesla zakaznika z role admina
     * 
     * @param Illuminate\Http\Request
     */
    public function updatePasswordAdmin(Request $request, $id)
    {
        // overeni udaju z formulare
        $this->validate($request, [
            'password' => 'required|confirmed', 
        ]);

        $customer = Customer::find($id); // vyhledani zakaznika podle ID
   
        $customer->password = Hash::make($request->password); // zmena hesla
        $customer->save(); // ulozeni v databazi
        
        return back()->with('success', 'Heslo úspěšně změněno');

    }

    
    
}
