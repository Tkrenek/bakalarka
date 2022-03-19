<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;


class RegisterSubController extends Controller
{
    public function index()
    {
        $customers = Subscriber::get();

        return view('subscribers.index',[
            'customers' => $customers
        ]);
    }

    public function create(Request $request)
    {
        return view('subscribers.register');
    }

    public function store(Request $request)
    {

    $this->validate($request, [
            'name' => 'required|unique:subscribers',
            'town' =>'required',
            'address' => 'required|unique:subscribers',
            'login' => 'required|unique:subscribers',
            'password' => 'required|confirmed',
            'url' =>'required|unique:subscribers',

        ]);

        Subscriber::create([
            'name' => $request->name,
            'town' => $request->town,
            'address' => $request->address,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'url' => $request->url,

        ]);

        $credentials = $request->only('login', 'password');
 
        if (Auth::guard('subscriber')->attempt($credentials)) {
            return view('subscribers/welcome');
        } else {
            return back()->with('error', 'Zadán chybný login nebo heslo.');
        }

        

        
    }

    public function edit($id)
    {
        $customer = Subscriber::where('id', $id)->first();
        return view('subscribers.update', [
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
            'password' => 'confirmed',
            'url' =>'required',
            
        ]);
 
        $subscriber = Subscriber::find($id);

        $subscriber->name = $request->name;
        $subscriber->address = $request->address;
        $subscriber->town = $request->town;
        $subscriber->password = Hash::make($request->password);
        $subscriber->login = $request->login;
        $subscriber->url = $request->url;        
 

        $subscriber->save();

        $customers = Subscriber::get();
        return view('subscribers.index', [
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
        $subscriber = Subscriber::find($id);
        $subscriber->delete();

        return back();
    }
}
