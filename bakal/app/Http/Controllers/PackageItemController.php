<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Container;

use App\Models\Package_item;
use App\Models\Item;

class PackageItemController extends Controller
{
    public function create($itemid)
    {

        $containers = Container::get();

        

        return view('packageItem.create', [
            'containers' => $containers,
            'itemid' => $itemid
        ]);
    }

    public function store($itemid, Request $request)
    {
        $this->validate($request, [
            'count' => 'required',

        ]);
        
        $parts = explode(" - ", $request->container);
        $type = $parts[0];
        $bulk = $parts[1];

        $container = Container::where('type', '=', $type)->where('bulk', '=', $bulk)->first();
       
        if(Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $container->id)->first()) {
            $pckgItem = Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $container->id)->first();
            $pckgItem->count += $request->count;

            $pckgItem->save();
        } else {
            Package_item::create([
                'item_id' => $itemid,
                'container_id' => $container->id,
                'count' => $request->count,
    
            ]);
        }

        

        $container->on_store -= $request->count;

        $container->save();

        $item = Item::find($itemid);
  

        
        return \Redirect::route('orders.show', $item->order->id);
        
    }
}
