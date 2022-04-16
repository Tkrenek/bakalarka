<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;

class ProducerController extends Controller
{
    public function create()
    {
        return view('producers.create');
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
    
}
