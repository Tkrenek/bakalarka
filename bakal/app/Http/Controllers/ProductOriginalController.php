<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producer;
use App\Models\Product_original;
use App\Models\Product_mixed;

class ProductOriginalController extends Controller
{
    public function create()
    {
        $producers = Producer::get();

        return view('originalProduct.create', [
            'producers' => $producers
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch' =>'required',
            'code' => 'required',
            'prize' => 'required|numeric',
            'on_store' => 'required',
            'producer' => 'required',

            
        ]);
        $producer = Producer::where('name', $request->producer)->first();
        
       
        Product_original::create([
            'name' => $request->name,
            'branch' => $request->branch,
            'code' => $request->code,
            'prize' => $request->prize,
            'on_store' => $request->on_store,
            'producer_id' => $producer->id,

        ]);
    
        $products = Product_original::get();
        
        $productsMixed = Product_mixed::get();
    
       

        return view('originalProduct.index', [
            'products' => $products,
            'productsMixed' => $productsMixed

        ]);
    }

  
    public function index()
    {
        
        $products = Product_original::get();
        
        $productsMixed = Product_mixed::get();
    
       

        return view('originalProduct.index', [
            'products' => $products,
            'productsMixed' => $productsMixed

        ]);
    }

    public function edit($id)
    {
    
        $product = Product_original::where('id', $id)->first();
        $producers = Producer::get();
        return view('originalProduct.update', [
            'product' => $product,
            'producers' => $producers,
        ]);


    }

    public function update(Request $request, $id)
    {
      

    $this->validate($request, [
        
            'name' => 'required',
            'branch' =>'required',
            'prize' => 'required|numeric',
            'on_store' => 'required|numeric',
            'producer' => 'required'
        ]);
        
        $product = Product_original::find($id);

        $producer = Producer::where('name', $request->producer)->first();

  
        
        $product->name = $request->name;
        $product->branch = $request->branch;
        $product->prize = $request->prize;
        $product->on_store = $request->on_store;
        $product->producer_id = $producer->id;

        
        $product->save();

        $products = Product_original::get();
        $productsMixed = Product_mixed::get();

        return redirect()->route('product.index');
      
    }

    public function destroy($id)
    {
        $product = Product_original::find($id);
        $product->delete();

        return back();
    }

    public function addOnStore($id, Request $request)
    {
        $this->validate($request, [
        
            'ammount' => 'required|numeric',
        ]);

        $product = Product_original::find($id);


        $product->on_store = $product->on_store + $request->ammount;

        $product->save();

        return back();
        
    }
    
}

