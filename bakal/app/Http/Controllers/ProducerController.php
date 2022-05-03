<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;

class ProducerController extends Controller
{

    public function index()
    {
        $producers = Producer::get();

        return view('producers.index', [
            'producers' => $producers
        ]);
    }

    public function create()
    {
        return view('producers.create');
    }

    public function edit($id)
    {
        $producer = Producer::find($id);
        return view('producers.edit', [
            'producer' => $producer
        ]);
    }

    public function update(Request $request, $id)
    {
       

        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required',
            'address' =>'required',
            'town' => 'required',
            'email' => 'required|email|unique:producers',
            'phone' => 'required|numeric|unique:producers',
        ]);
 
        $producer = Producer::find($id); // vyhledani zakaznika podle ID

        // zmeni udaje zakaznika
        $producer->name = $request->name;
        $producer->address = $request->address;
        $producer->town = $request->town;
        $producer->email = $request->email;
        $producer->phone = $request->phone;        

        $producer->save(); // ulozi udaje zakaznika v databazi

        

        return redirect()->route('producers.index'); 
        
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:producers',
            'phone' => 'required|numeric|unique:producers',
            'email' => 'required|email|unique:producers',
            'address' =>'required',
            'town' => 'required'
            
        ]);
        

        Producer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'town' => $request->town,


        ]);

        

        return back();
    }

    public function destroy($id)
    {
        $producer = Producer::find($id);

        $producer->delete();
        return back();
    }
    
}
