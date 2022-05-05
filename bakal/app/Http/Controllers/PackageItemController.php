<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Container;

use App\Models\Package_item;
use App\Models\Item;

class PackageItemController extends Controller
{

    /**
     * Vraci formular pro vytvoreni novehozabaleni objednavky
     * @return \Illuminate\View\View
     */
    public function create($itemid)
    {

        $containers = Container::get(); // ziskame vsechny nadoby

        $item = Item::find($itemid); // najdeme polozku podle ID

        // vratime pohled 
        return view('packageItem.create', [
            'containers' => $containers,
            'item' => $item
        ]);
    }

    /**
     * Uchovani zabaleni polozky v databazi
     * @param Illuminate\Http\Request
     */
    public function store($itemid, Request $request, $containerid)
    {
        // overeni dat
        $this->validate($request, [
            'count' => 'required|numeric|min:1',
        ]);

        $cont = Container::find($containerid); // vyhledani nadby podle ID
        
    
        $parts = explode("-", $cont->code); // rozdelime kod nadoby, abychom ziskali informace o typu a objemu nadoby
        
        $type = $parts[0];
        $bulk = $parts[1];
   
        $container = Container::where('type', '=', $type)->where('bulk', '=', $bulk)->first(); // vyhledani nadoby v databazi
       
        if(Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $cont->id)->first()) { // pokud uz polozka je zabalene v teto nadobe
            
            // overeni jestli je na sklade dost zasob
            if($request->count > $cont->on_store) {
                return back()->with('error', 'Na skladě není dost zásob.'); // chbov hlaska
            }

            $pckgItem = Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $cont->id)->first(); // vyhledani konkretniho zabaleni
            $pckgItem->count += $request->count; // navyseni poctu
            $pckgItem->save(); // ulozeni

        } else {
            // overeni jestli je na sklade dost zasob
            if($request->count > $cont->on_store) {
                return back()->with('error', 'Na skladě není dost zásob.'); // chbova hlaska
            }
            // vytvoreni noveho zabaleni objdnavky
            Package_item::create([
                'item_id' => $itemid,
                'container_id' => $cont->id,
                'count' => $request->count,
    
            ]);
        }

        
        $cont->on_store -= $request->count; // odecteni nadoby ze skladu
        $cont->save();

        $item = Item::find($itemid); // vyhledani polozky podle ID
  
        return \Redirect::route('orders.show', $item->order->id); // presmerovani
        
    }

    /**
     * Metoda prozobrazeni kokretniho zabaleni jedne polozky
     * @return \Illuminate\View\View
     */
    public function show($itemid)
    {
        $item = Item::find($itemid); // vyhledai polozky podle ID

        // vraceni pohledu
        return view('packageItem.show', [
            'item' => $item
        ]);
    }

    /**
     * Metoda pro odstraneni zabaleni zakazky z databaze
     * @param Illuminate\Http\Request
     */
    public function destroy($id)
    {
        $packageItem = Package_item::find($id); // vyhledani baleni polozky
       
        $packageItem->container->on_store += $packageItem->count; // vraceni poctu nadob na sklad
        $packageItem->container->save(); //ulozeni
        $packageItem->delete(); // vymazani

        return back();
    }

    /**
     * Metoda pro zmenu poctu kusu baleni
     * @param Illuminate\Http\Request
     */
    public function changeCount($id, Request $request)
    {
        // overeni dat 
        $this->validate($request, [
            'count' => 'required|numeric|min:1',
            
        ]);
        

        $pckgItem = package_Item::find($id); // vyhledani zabaleni podle ID
 
        $order = $pckgItem->item->order; // zjisteni objednavky ke ktere baleni patri
        if($request->count > $pckgItem->count) { // pokud se pocet zmeni na vyssi
            $pckgItem->container->on_store -= $request->count - $pckgItem->count; // musime odecist ze skladu
            
        } else { // pokud naopak
            
            $pckgItem->container->on_store += $pckgItem->count - $request->count; // musime pricist
        }
        $pckgItem->count = $request->count; // zmena poctu
        $pckgItem->container->save(); // ulozeni poctu na sklade
        
        $pckgItem->save(); // ulozni poctu

        return \Redirect::route('orders.show', $order->id); // presmerovani
    }
    
}
