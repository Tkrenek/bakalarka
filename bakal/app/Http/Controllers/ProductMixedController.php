<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product_mixed;

use App\Models\Product_original;

class ProductMixedController extends Controller
{
    public function create()
    {
        return view('mixedProduct.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch' =>'required',
            'code' =>'required',
            'prize' => 'required|numeric',

        ]);
        
       
        Product_mixed::create([
            'name' => $request->name,
            'code' => $request->code,
            'branch' => $request->branch,
            'prize' => $request->prize,
            'on_store' => 0

        ]);
    
        $products = Product_original::get();
        
        $productsMixed = Product_mixed::get();
    
       

        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $productMixed = Product_mixed::Find($id);


        return view('mixedProduct.edit', [
            'productMixed' => $productMixed
        ]);
    }

    public function update(Request $request, $id)
    {
        $productMixed = Product_mixed::Find($id);
        

        $this->validate($request, [
        
            'name' => 'required',
            'branch' =>'required',
            'prize' => 'required|numeric|min:1',
   
        ]);
        
        $productMixed->name = $request->name;
        $productMixed->branch = $request->branch;
        $productMixed->prize = $request->prize;
        $productMixed->branch = $request->branch;

        
        $productMixed->save();

        $products = Product_original::get();
        $productsMixed = Product_mixed::get();
        
        return redirect()->route('product.index');
        
    }

    public function addOnStore(Request $request, $id)
    {

        $this->validate($request, [
        
            'ammount' => 'required|numeric|min:1',
        ]);

        $product = Product_mixed::find($id);



        $product->on_store += $request->ammount;

        $product->save();

        $products = Product_original::get();
        $productsMixed = Product_mixed::get();


  
        
        foreach($product->mixingProduct as $orig) {
            
            if($request->ammnount < $orig->productOriginal->on_store) {
                
                return back()->with('error', 'Na skladě není dost produktu na namíchání.');
            } else {
                $orig->productOriginal->on_store -= $request->ammount;
                $orig->productOriginal->save();
            }
            
        }
        
        
        return back();
    }

    public function destroy($id)
    {
        $product = Product_mixed::find($id);
        $product->delete();

        return back();
    }

}
