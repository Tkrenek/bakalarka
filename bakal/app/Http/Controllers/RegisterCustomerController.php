<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;


class RegisterCustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::get();

        return view('customers.index',[
            'customers' => $customers
        ]);
    }

    public function create(Request $request)
    {
        return view('customers.register');
    }

    public function store(Request $request)
    {

    $this->validate($request, [
            'name' => 'required|unique:customers',
            'town' =>'required',
            'address' => 'required|unique:customers',
            'login' => 'required|unique:customers',
            'password' => 'required|confirmed',
            'url' =>'unique:customers',

        ]);

        Customer::create([
            'name' => $request->name,
            'town' => $request->town,
            'address' => $request->address,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'url' => $request->url,

        ]);

        $credentials = $request->only('login', 'password');
 
        if(auth('admin')->user()) {
          
            return redirect()->route('customers.index');
        }
        if (Auth::guard('customer')->attempt($credentials)) {
            return view('customers/welcome');
        } else {
            return back()->with('error', 'Zadán chybný login nebo heslo.');
        }

        

        
    }

    public function edit($id)
    {
        $customer = Customer::where('id', $id)->first();
        return view('customers.update', [
            'customer' => $customer
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' =>'required',
            'town' => 'required',
            'login' => 'required',
       
            'url' =>'required',
            
        ]);
 
        $customer = Customer::find($id);

        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->town = $request->town;

        $customer->login = $request->login;
        $customer->url = $request->url;        
 

        $customer->save();

        $customers = Customer::get();
        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        return back();
    }

    public function change_password()
    {
        return view('customers.change_password');
    }

    public function update_password(Request $request, $id)
    {
        $customer = Customer::find($id);
        

        
        $this->validate($request, [
            'password_old' => 'required',
            'password' => 'required|confirmed',
            
        ]);


        if(Hash::check($request->password_old, $customer->password)) {
            $customer->password = Hash::make($request->password);
            $customer->save();
            return back();
        } else {
            return back()->with('error', 'Zadáno chybné staré heslo');
        }

    }

    public function change_passwordAdmin($id)
    {
        $customer = Customer::find($id);

        return view('customers.change_passwordAdmin', [
            'customer' => $customer
        ]);
    }

    public function update_passwordAdmin(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed', 
        ]);


        $customer = Customer::find($id);
   
            $customer->password = Hash::make($request->password);
            $customer->save();
            return back();

    }

    
    
}
