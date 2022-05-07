<?php
/**
 * Nazev souboru: ProductMixedController.php
 * Controller pro michane produkty
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product_mixed;

use App\Models\Product_original;

class ProductMixedController extends Controller
{
    /**
     * Vraci formular pro vytvoreni noveho michaneho produktu
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('mixedProduct.create'); // vraceni pohledu
    }

    /**
     * Metoda pro vlozeni noveho michaneho produktu do databaze
     * @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'name' => 'required',
            'branch' =>'required',
            'code' =>'required',
            'prize' => 'required|numeric',

        ]);
        
        // vytvoreni noveho produktu
        Product_mixed::create([
            'name' => $request->name,
            'code' => $request->code,
            'branch' => $request->branch,
            'prize' => $request->prize,
            'on_store' => 0

        ]);
    
        return redirect()->route('product.index'); // presmerovani
    }

    /**
     * Pohled pro upravu michaneho produktu
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $productMixed = Product_mixed::Find($id); // vyhledani prouktu podle ID

        // Vraceni pohledu pro upravu
        return view('mixedProduct.edit', [
            'productMixed' => $productMixed
        ]);
    }

    /**
     * Upravi data o produktu v databazi
     * @param Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
        $productMixed = Product_mixed::Find($id); //vyhledani produktu podle ID
        
        // overeni dat z formulare
        $this->validate($request, [
            'name' => 'required',
            'branch' =>'required',
            'prize' => 'required|numeric|min:1',
            'on_store' => 'required|numeric|min:1',
   
        ]);
        
        // upraveni udaju o produktu
        $productMixed->name = $request->name;
        $productMixed->branch = $request->branch;
        $productMixed->prize = $request->prize;
        $productMixed->branch = $request->branch;
        $productMixed->on_store = $request->on_store;
        
        $productMixed->save(); // ulozeni produktu
        
        return redirect()->route('product.index'); // presmerovani
        
    }


    /**
     * Metoda pro naskladneni produktu
     * @param Illuminate\Http\Request
     */
    public function addOnStore(Request $request, $id)
    {
        // Overeni udaju z formulare
        $this->validate($request, [
            'ammount' => 'required|numeric|min:1',
        ]);

        // Vyhledani produktu podle ID
        $product = Product_mixed::find($id);
        $product->on_store += $request->ammount; //Naskladneni
        $product->save();

        $products = Product_original::get();
        $productsMixed = Product_mixed::get();
        
        // odecteni originalnich produktu ze skladu, ktere jsou v receptu michaneho
     

        // odecteni produktu ze skladu, ktere jsou soucasti receptu
        foreach($product->mixingProduct as $orig) {
            
            if($request->ammount > $orig->productOriginal->on_store) {
        
                return back()->with('error', 'Na skladě není dost zásob na namíchání produktu.');
                
            } else {
                $orig->productOriginal->on_store -= $request->ammount;
                $orig->productOriginal->save();
            }
            
        }

        return back();
    }

    /**
     * Metoda pro odstraneni michaneho produktu
     */
    public function destroy($id)
    {
        $product = Product_mixed::find($id); // vyhledani produktu podle ID
        $product->delete(); // odstraneni produktu

        return back();
    }

}
