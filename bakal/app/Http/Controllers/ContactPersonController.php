<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscriber;

use App\Models\ContactPerson;
use Illuminate\Support\Facades\Auth;

class ContactPersonController extends Controller
{
    public function create()
    {
        $subscribers = Subscriber::get();
        return view('contact.create', [
            'subscribers' => $subscribers
        ]);
        
    }

    public function createAsAdmin($subId)
    {
        $subscriber = Subscriber::find($subId);
        return view('contact.create', [
            'subscriber' => $subscriber
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
        

          
            ContactPerson::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
    
                'birth_date' => $request->birth_date,
                
                
                'subscriber_id' => auth('subscriber')->user()->id,
    
            ]);
        
        

        

        return back();
    }

    public function storeAsAdmin(Request $request, $subId)
    {
    
    $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:employees',
            'birth_date' =>'required|date',
            
        ]);

        

     

          
            ContactPerson::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
    
                'birth_date' => $request->birth_date,
                
                
                'subscriber_id' => $subId,
    
            ]);
        
        

        

        return back();
    }


    public function index()
    {
        $contacts = ContactPerson::get();

        return view('contact.index', [
            'contacts' => $contacts
        ]);
    }

    public function edit($id)
    {
        $contact = ContactPerson::where('id', $id)->first();
        return view('contact.update', [
            'contact' => $contact
        ]);


    }


    public function update(Request $request, $id)
    {
    
   
    $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            
            'birth_date' =>'required|date',
        ]);

    

        $contact = ContactPerson::find($id);

        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->phone = $request->phone;
   
        $contact->email = $request->email;
      
        $contact->birth_date = $request->birth_date;

    

        $contact->save();

        $contacts = ContactPerson::get();
        return view('contact.index', [
            'contacts' => $contacts
        ]);
      
    }

    public function destroy($id)
    {
        $contact = ContactPerson::find($id);
        $contact->delete();

        return back();
    }

    public function indexSub($subId)
    {
        
        $subscriber = Subscriber::find($subId);
        $contacts = $subscriber->contact;

        return view('contact.subindex', [
            'contacts' => $contacts
        ]);
    }

    
    
}

