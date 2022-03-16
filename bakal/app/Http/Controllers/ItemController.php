<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product_original;
use App\Models\Product_mixed;

use App\Models\Order;


class ItemController extends Controller
{
    public function create($orderid)
    {
        $products = Product_original::get();
        $productsMixed = Product_mixed::get();


        $order = Order::Find($orderid);

        return view('items.create', [
            'products' => $products,
            'productsMixed' => $productsMixed,
            'order' => $order
        ]);
    }

    public function store(Request $request, $orderid)
    {
        $this->validate($request, [
            'amount' => 'required',
            'product' => 'required',
        ]);



        if($request->product[0] == "O") {
            $product = Product_original::where('code', $request->product)->first();
            Item::create([
                'amount' => $request->amount,
                'is_mixed' => "ne",
                'product_original_id' => $product->id,
                'product_mixed_id' => 2,
                'order_id' => $orderid

            ]);

            $product->on_store -= $request->amount;
            $product->save();
        } else {
            
            $product = Product_mixed::where('code', $request->product)->first();
   
            Item::create([
                'amount' => $request->amount,
                'is_mixed' => "ano",
                'product_original_id' => 2,
                'product_mixed_id' => $product->id,
                'order_id' => $orderid

            ]);

            $product->on_store -= $request->amount;
            $product->save();
        }

            return \Redirect::route('orders.show', $orderid);
    }
    

    
}
