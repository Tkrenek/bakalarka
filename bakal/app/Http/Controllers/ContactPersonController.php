<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

use App\Models\ContactPerson;
use Illuminate\Support\Facades\Auth;

class ContactPersonController extends Controller
{
    /**
     * Vraci formular pro vytvvni kontaktni osoby
     * @return \Illuminate\View\View
     */ 
    public function create()
    {
        $customers = Customer::get();  // uložení všech zákazníků do proměnné

        return view('contact.create', [ // pohled se všemi zákazníky
            'customers' => $customers
        ]);
        
    }

    /**
     * Vraci pohled s formularem pro vytvoreni kontaktni osoby
     * pro zakaznika z role admina
     * 
     * @return \Illuminate\View\View
     */ 
    public function createAsAdmin($customerId)
    {
        $customer = Customer::find($customerId); // Vyhledani zákazníka podle ID

        return view('contact.create', [  // vraci pohled se zakaznikem
            'customer' => $customer
        ]);
        
    }

    /**
     * 
     * Ulozi udaje o kontaktni osobe do databaze
     * 
     * @param Illuminate\Http\Request
     */ 
    public function store(Request $request)
    {
        // validace zadaných údajů ve formuláři
        $this->validate($request, [ 
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

    /**
     * Ulozi udaje o kontaktni osobe do databaze
     * z role admina
     * 
     * @param Illuminate\Http\Request
     */ 
    public function storeAsAdmin(Request $request, $subId)
    {
    
        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:employees',
            'birth_date' =>'required|date',
            
        ]);


        // vytvoreni nove kontaktni osoby
        ContactPerson::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'customer_id' => $subId,
        ]);
        
        return redirect()->route('contact.index'); // presmerovani
    }


    /**
     * Vraci pohle se vsemi kontaktnimi osobami
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        
        $contacts = ContactPerson::get(); // vsechny kontaktni osoby ulozi do promenne

        $customer = Customer::find($id);

        $contacts = $customer->contact;
        $contact = ContactPerson::find($id);
        // vraci pohled s promennou, ve ktere jsou vsechny kontaktni osoby
        return view('contact.index', [
            'contacts' => $contacts
        ]);
    }


    /**
     * Vraci pohle s formularem pro upravu kontaktni osoby
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $contact = ContactPerson::where('id', $id)->first(); // vyhledani kontaktni osoby podle ID

        // pohled s touto kntaktni osobou
        return view('contact.update', [
            'contact' => $contact
        ]);


    }

    /**
     * Upravi udaje o kontaktni osobe v databazi
     * 
     * @param Illuminate\Http\Request
     */ 
    public function update(Request $request, $id)
    {
   
        // overi zadane udaje z formulare
        $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'birth_date' =>'required|date',
        ]);

        $contact = ContactPerson::find($id); // vyhleda osobu podle ID

        // Upravi se udaje
        $contact->name = $request->name;
        $contact->surname = $request->surname;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->birth_date = $request->birth_date;

        $contact->save(); // ulozeni v databazi

        $contacts = ContactPerson::get(); // ziskani vsech kontaktnich osob

        // pohed se vsemi kontaktnimi osobami
        return view('contact.index', [
            'contacts' => $contacts
        ]);
      
    }

    /**
     * Odstrani zaznam z databaze
     */
    public function destroy($id)
    {
        $contact = ContactPerson::find($id); // vyhleda osobu podle ID
        $contact->delete();  // smaze osobu

        return back();
    }

    /**
     * Zobrazeni pohledu svych kontaktnich osob pro
     * zakaznika
     * 
     * @return \Illuminate\View\View
     */
    public function indexSub($subId)
    {
        
        $customer = Customer::find($subId); // vyhledani zakaznika podle ID
        $contacts = $customer->contact; // ulozeni kontaktnich osob do promenne

        // pohled s kontaktnimi osobami
        return view('contact.subindex', [
            'contacts' => $contacts
        ]);
    }
}

