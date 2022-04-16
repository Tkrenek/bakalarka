<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

use App\Models\ContactPerson;
use Illuminate\Support\Facades\Auth;

class ContactPersonController extends Controller
{
    /**
     * Funkce, která vrátí pohled obsahující formulář
     * pro přidání kontaktní osoby
     * 
     */
    public function create()
    {
        $customers = Customer::get();  // uložení všech zákazníků do proměnné

        return view('contact.create', [ // pohled se všemi zákazníky
            'customers' => $customers
        ]);
        
    }

    /**
     * Funkce pro vytvořní kontaktní osoby,
     * pokud je přihlášen d systému admin
     * 
     * $subId  Parametr určující id zákazníka,
     * ke kterému bude kontaktní osoba přiřazena
     */
    public function createAsAdmin($subId)
    {
        $customer = Customer::find($subId); // Nalezení zákazníka podle ID

        return view('contact.create', [
            'customer' => $customer
        ]);
        
    }

    /**
     * Funkce pro uchování záznamu o kontaktní osobě
     */
    public function store(Request $request)
    {
    
        $this->validate($request, [ // validace zadaných údajů ve formuláři
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:employees',
            'birth_date' =>'required|date',
        ]);
        

        // vytvoření kontaktní osoby s údaji z formuláře
        ContactPerson::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'customer_id' => auth('customer')->user()->id,
        ]);
      
        // přesměrování na kontatní osoby
        return redirect()->route('contact.index.sub', ['subId' => auth('customer')->user()->id]);
            
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
                
                
                'customer_id' => $subId,
    
            ]);
        
            return redirect()->route('contact.index');
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
        
        $customer = Customer::find($subId);
        $contacts = $customer->contact;

        return view('contact.subindex', [
            'contacts' => $contacts
        ]);
    }
}

