<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product_original;
use App\Models\Product_mixed;

use App\Models\Order;


class ItemController extends Controller
{
    /**
     * Vraci pohled pro pridani polozky do objednavky
     * @return \Illuminate\View\View
     */
    public function create($orderid)
    {
        $products = Product_original::get(); // vyhleda vsechny originalni produkty
        $productsMixed = Product_mixed::get(); // vyhleda vsechny michane produkty

        $order = Order::Find($orderid); // vyhleda objedavku podle ID

        // vrati pohled
        return view('items.create', [
            'products' => $products,
            'productsMixed' => $productsMixed,
            'order' => $order
        ]);
    }

    /**
     * Vlozi do databaze zaznam s nonou polozkou 
     * @param Illuminate\Http\Request
     */
    public function store(Request $request, $orderid, $productcode)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'ammount' => 'required',
        ]);


        // pokud se jedna o originalni produkt
        if($productcode[0] == "O") {
       
            $product = Product_original::where('code', $productcode)->first(); // vyhledani originalniho produktu podle jeho kodu

            if($request->ammount > $product->on_store) { // pokud neni na sklade dost zasob 
                return back()->with('error', 'Na skladě není dost zásob.'); // chybova hlaska
            }

            // pokud v databazi je polozka soucasti objednvky
            if($item = Item::where('is_mixed', 'ne')->where('product_original_id', $product->id)->where('order_id', "=", $orderid)->first()) {
                $item->amount += $request->ammount; // pouze navysime mnozstvi
                $item->save();
            }else{ // pokud jeste neni v databazi soucasti objednavky
                // vytvorime novy zaznam
                Item::create([
                    'amount' => $request->ammount,
                    'is_mixed' => "ne",
                    'product_original_id' => $product->id,
                    'product_mixed_id' => 1,
                    'order_id' => $orderid
    
                ]);
             }
            $product->on_store -= $request->ammount; // odecteme mnozstvi produktu ze skladu
            $product->save();
        } else { // pokud se jedna o michany produkt
            
            $product = Product_mixed::where('code', $productcode)->first(); // vyhledame produkt podle kodu

            if($request->ammount > $product->on_store) { // pokud neni na sklade dost zasob
                return back()->with('error', 'Na skladě není dost zásob.'); // chybova hlaska
            }
            // pokud uz v databazi je polozka u konkretni objednavky
            if($item = Item::where('is_mixed', 'ano')->where('product_original_id', $product->id)->where('order_id', "=", $orderid)->first()) {
                $item->amount += $request->ammount; // zvysime jenom mnozstvi
                $item->save();
            } else { // pokud tam jeste neni
                // vytvorime novou polozku v databazi
                Item::create([
                    'amount' => $request->ammount,
                    'is_mixed' => "ano",
                    'product_original_id' => 1,
                    'product_mixed_id' => $product->id,
                    'order_id' => $orderid
    
                ]);
            }
            
            // odecteme mnozstvi na sklade
            $product->on_store -= $request->ammount;
            $product->save();
        }

        return \Redirect::route('orders.show', $orderid);
    }

    /**
     * Ostrani zaznam o polozce z databaze
     * @param Illuminate\Http\Request
     */
    public function destroy($id)
    {
        $item = Item::find($id); // vyhledani polozky podle ID

        // pokud se jedna o michany produkt
        if($item->is_mixed == "ano") {
            $item->productMixed->on_store += $item->amount; // naskladnime zpet michany produkt
            $item->productMixed->save();
        } else { // pokud se jedna o originalni produkt
            $item->productOriginal->on_store += $item->amount; // naskladnime zpet originalni produkt
            $item->productOriginal->save();
        }

        $item->delete(); // smazeme polozku z databaze

        return back();
    }

    

    
}
