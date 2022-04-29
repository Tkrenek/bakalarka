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

        $item = Item::find($itemid);

        return view('packageItem.create', [
            'containers' => $containers,
            'item' => $item
        ]);
    }

    public function store($itemid, Request $request, $containerid)
    {
        $this->validate($request, [
            'count' => 'required',

        ]);

        $cont = Container::find($containerid);
        
    
        $parts = explode("-", $cont->code);
        
        $type = $parts[0];
        
        $bulk = $parts[1];
   
        $container = Container::where('type', '=', $type)->where('bulk', '=', $bulk)->first();
       
        if(Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $cont->id)->first()) {
            
            if($request->count > $cont->on_store) {
                return back()->with('error', 'Na skladě není dost zásob.');

            }
            $pckgItem = Package_item::where('item_id', '=', $itemid)->where('container_id', '=', $cont->id)->first();
            $pckgItem->count += $request->count;

            $pckgItem->save();
        } else {
            
            Package_item::create([
                'item_id' => $itemid,
                'container_id' => $cont->id,
                'count' => $request->count,
    
            ]);
        }

        

        $cont->on_store -= $request->count;

        $cont->save();

        $item = Item::find($itemid);
  

        
        return \Redirect::route('orders.show', $item->order->id);
        
    }

    public function show($itemid)
    {
        $item = Item::find($itemid);

        return view('packageItem.show', [
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $packageItem = Package_item::find($id);
        
       
        $packageItem->container->on_store += $packageItem->count;

        $packageItem->container->save();
        $packageItem->delete();

        return back();
    }

    public function changeCount($id, Request $request)
    {
        $this->validate($request, [
            'count' => 'required|numeric',
            
        ]);
        

        $pckgItem = package_Item::find($id);

        $order = $pckgItem->item->order;
        $pckgItem->count = $request->count;
        $pckgItem->save();

        return \Redirect::route('orders.show', $order->id);
    }
    
}
