<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;
use App\Models\Product_original;
use App\Models\Product_mixed;

class ProductOriginalController extends Controller
{
    /**
     * Vrati pohled s formularem pro vytvoreni noveho originalniho produktu
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $producers = Producer::get(); // ziskani vsech dodavatelu

        // vraceni pohledu
        return view('originalProduct.create', [
            'producers' => $producers
        ]);
    }

    /**
     * Metoda pro vlozeni noveho produktu do databaze
     */
    public function store(Request $request)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'name' => 'required',
            'branch' =>'required',
            'code' => 'required',
            'prize' => 'required|numeric|min:1',
            'on_store' => 'required|numeric|min:1',
            'producer' => 'required',

            
        ]);

        $producer = Producer::where('name', $request->producer)->first(); // vyhledani vybraneho dodavatele
        
        // vytvoreni noveho produktu
        Product_original::create([
            'name' => $request->name,
            'branch' => $request->branch,
            'code' => $request->code,
            'prize' => $request->prize,
            'on_store' => $request->on_store,
            'producer_id' => $producer->id,

        ]);
    
       return redirect()->route('product.index'); // presmerovani
   
    }

    /**
     * Zobrazeni vsech produktu
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ziskani vsech produktu
        $products = Product_original::get(); 
        $productsMixed = Product_mixed::get();

        // vraceni pohledu se vsemi produkty
        return view('originalProduct.index', [
            'products' => $products,
            'productsMixed' => $productsMixed

        ]);
    }

    /**
     * Zobrazeni pouze originalnich produktu
     * @return \Illuminate\View\View
     */
    public function indexOriginal()
    {
        
        $products = Product_original::get(); // ziskani originalnich produktu

        // vraceni pohledu
        return view('originalProduct.indexOriginal', [
            'products' => $products,
        ]);
    }

    /**
     * Zobrazeni pouze michanych produktu
     * @return \Illuminate\View\View
     */
    public function indexMixed()
    {

        $productsMixed = Product_mixed::get(); // ziskani michanych produktu

        // vraceni pohledu
        return view('originalProduct.indexMixed', [
            'productsMixed' => $productsMixed,
        ]);
    }

    /**
     * Vraci pohled pro zmenu produktu
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
    
        $product = Product_original::where('id', $id)->first(); // vyhledani produktu podle jeho ID
        $producers = Producer::get(); // vsechny produkty

        // vraceni pohledu
        return view('originalProduct.update', [
            'product' => $product,
            'producers' => $producers,
        ]);


    }
    /**
     * Metoda slouzici pro upravu originalniho produktu
     * @param Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
      
    // overeni dat z formulare
    $this->validate($request, [
        
            'name' => 'required',
            'branch' =>'required',
            'prize' => 'required|numeric',
            'on_store' => 'required|numeric',
            'producer' => 'required'
        ]);
        
        $product = Product_original::find($id); // vyhledani produktu podle ID

        
        $producer = Producer::where('name', $request->producer)->first(); // Vyhledani dodavatele podle ID
        
        // zmena udaju o produktu
        $product->name = $request->name;
        $product->branch = $request->branch;
        $product->prize = $request->prize;
        $product->on_store = $request->on_store;
        $product->producer_id = $producer->id;
        
        $product->save(); // ulozeni produktu

        return redirect()->route('product.index'); // presmerovani
      
    }

    /**
     * Metoda pro odstraneni produktu z databaze
     */
    public function destroy($id)
    {
        $product = Product_original::find($id); // vyhledani produktu podle ID
        $product->delete();  // smazani produktu

        return back();
    }

    /**
     * Metoda pro naskladneni produktu
     * @param Illuminate\Http\Request
     */
    public function addOnStore($id, Request $request)
    {
        // overeni dat
        $this->validate($request, [
            'ammount' => 'required|numeric|min:1',
        ]);

        $product = Product_original::find($id); // vyhledani produktupodle ID

        $product->on_store = $product->on_store + $request->ammount; // zmena poctu na sklade

        $product->save(); // ulozeni

        return back();
        
    }
    
}

