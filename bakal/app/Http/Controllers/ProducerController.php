<?php
/**
 * Nazev souboru: ProducerController.php
 * Controller pro spravu dodavatelu
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;

class ProducerController extends Controller
{

    /**
     * Zobrazi pohled se vsemi dodavateli
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $producers = Producer::get(); // vyhledani vsech dodavatelu

        // vraceni pohledu
        return view('producers.index', [
            'producers' => $producers
        ]);
    }

    /**
     * vraci formular pro vytvoreni noveho dodavatele
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('producers.create'); // vraceni pohledu
    }

    /**
     * Vraci formular pro upravu dodavatele
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $producer = Producer::find($id); // vyhledani dodavatele podle ID

        // vraceni pohledu s formularem
        return view('producers.edit', [
            'producer' => $producer
        ]);
    }


    /**
     * Zmeni data o dodavateli v databazi
     * @param Illuminate\Http\Request
     */
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

        

        return redirect()->route('producers.index'); // presmerovani
        
        
    }

    /**
     * Vytvori v databazi zaznam o novem dodavateli
     * @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // overi data z formulare
        $this->validate($request, [
            'name' => 'required|unique:producers',
            'phone' => 'required|numeric|unique:producers',
            'email' => 'required|email|unique:producers',
            'address' =>'required',
            'town' => 'required'
            
        ]);
        
        // vytvoreni dodavatele
        Producer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'town' => $request->town,


        ]);

        return back();
    }

    /**
     * Smaze dodavatele z databaze
     */
    public function destroy($id)
    {
        $producer = Producer::find($id); // vyhledani dodavatele podle ID

        $producer->delete(); // smazani dodavatele
        
        return back();
    }
    
}
