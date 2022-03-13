<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;

class ProducerController extends Controller
{
    public function index()
    {
        return view('producers.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:producers',
            'phone' => 'required|numeric|unique:producers',
            'email' => 'required|email|unique:producers',
            'address' =>'required|unique:producers',
            
        ]);
        

        Producer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' =>'required|unique:producers',


        ]);

        

        return back();
    }
    
}
