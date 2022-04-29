<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product_original;
use App\Models\Product_mixed;
use App\Models\Mixing_product;

class MixingProductController extends Controller
{
    
    /**
     * Vraci pohled pro vytvoreni noveho receptu
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // vyhledani vsech produktu
        $mixeds = Product_mixed::get(); 
        $originals = Product_original::get();

        // vraceni pohledu se vsemi produkty
        return view('mixingProduct.create', [
            'mixeds' => $mixeds,
            'originals' => $originals
        ]);
    }

    /**
     * Vytvori novy zaznam o receptu v databazi 
     * @param Illuminate\Http\Request
     */
    public function store(Request $request, $mixedId)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'code' => 'required',           
        ]);

        $original = Product_original::where('code', $request->code)->first(); // vyhledani originalniho produktu podle kodu
        // pokud se zadny produkt nenasel
        if(!$original) {
            return back()->with('error', 'Tento produkt neexistuje'); // chybove hlaseni
        }

        // vyhledani michaneho produktu podle kodu
        $mixed = Mixing_product::where('product_mixed_id', $mixedId)->where('product_original_id', $original->id);

        // pokud jiz tento produkt je soucasti receptu
        if($mixed->first()) {
                return back()->with('error', 'Tato položka již v receptu je'); // chybove hlaseni
        }
        
        // vytvoreni receptu v databazi
        Mixing_product::create([
            'product_original_id' => $original->id,
            'product_mixed_id' => $mixedId,
            
        ]);

        return back();
    }

     /**
     * Zobrazi seznam vsech receptu
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mixeds = Product_mixed::get(); // vyhledani vsech michanych produktu

        // vreaceni pohledu
        return view('mixingProduct.index', [
            'mixeds' => $mixeds
        ]);
    }

    /**
     * Zobrazi recept jednoho produktu
     * @return \Illuminate\View\View
     */
    public function show($mixedId)
    {
        
        $mixedProduct = Product_mixed::find($mixedId); // vyhledani produktu podle ID
        $originals = Product_original::get();  // vyhledani vsech originalnich produktu
        
        // vraceni pohledu
        return view('mixingProduct.show', [
            'mixedProduct' => $mixedProduct,
            'originals' => $originals
        ]);
    }

    /**
     * Odstrani zaznam o receptu z databaze
     */
    public function destroy($mixingId)
    {
        $receipt = Mixing_Product::find($mixingId); // vyhleda recept podle ID
       
        $receipt->delete(); // smaze recept

        return back();
    }
}
