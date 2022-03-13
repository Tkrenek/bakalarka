<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscriber;

use App\Models\ContactPerson;


class ContactPersonController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::get();
        return view('contact.create', [
            'subscribers' => $subscribers
        ]);
        
    }

    public function store(Request $request)
    {
    
    $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:employees',
            'birth_date' =>'required|date',
            
        ]);
        $subscriber = Subscriber::where('name', $request->subscriber)->first();



        ContactPerson::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,

            'birth_date' => $request->birth_date,
            'subscriber_id' => $subscriber->id,

        ]);

        

        return back();
    }
}
