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

    public function store(Request $request, $orderid, $productcode)
    {
        $this->validate($request, [
            'ammount' => 'required',
        ]);


        
        if($productcode[0] == "O") {
            $product = Product_original::where('code', $productcode)->first();
            if($request->ammount > $product->on_store) {
                return back()->with('error', 'Na skladě není dost zásob.');

            }
           
            if($item = Item::where('is_mixed', 'ne')->where('product_original_id', $product->id)->where('order_id', "=", $orderid)->first()) {
                $item->amount += $request->ammount;
                $item->save();
            }else{
                Item::create([
                    'amount' => $request->ammount,
                    'is_mixed' => "ne",
                    'product_original_id' => $product->id,
                    'product_mixed_id' => 1,
                    'order_id' => $orderid
    
                ]);
             }


            $product->on_store -= $request->ammount;
            $product->save();
        } else {
            
            $product = Product_mixed::where('code', $productcode)->first();
            if($request->ammount > $product->on_store) {
                return back()->with('error', 'Na skladě není dost zásob.');
            }
            if($item = Item::where('is_mixed', 'ano')->where('product_original_id', $product->id)->where('order_id', "=", $orderid)->first()) {
                $item->amount += $request->ammount;
                $item->save();
            } else {
                Item::create([
                    'amount' => $request->ammount,
                    'is_mixed' => "ano",
                    'product_original_id' => 1,
                    'product_mixed_id' => $product->id,
                    'order_id' => $orderid
    
                ]);
            }
            

            $product->on_store -= $request->ammount;
            $product->save();
        }

            return \Redirect::route('orders.show', $orderid);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if($item->is_mixed == "ano") {
            $item->productMixed->on_store += $item->amount;
            $item->productMixed->save();
        } else {
            $item->productOriginal->on_store += $item->amount;
            $item->productOriginal->save();
        }
        $item->delete();

        return back();
    }

    public function frequency()
    {

        $transactions = [];
        
        
    }
    

    
}
