<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
//use App\Models\File;
use App\Models\Item;
use App\Models\Customer;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Phpml\Association\Apriori;

use DB;

class OrderController extends Controller
{ 
    public function test()
    {
        $samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'theta']];
        $labels  = [];
       
        $associator = new Apriori($support = 0.6, $confidence = 0.5);

        $associator->train($samples, $labels);
        dd($associator->predict(['alpha', 'beta']));
        
    }
    

    public function store()
    {
        
        
        $newOrder = Order::create([
            'state' => 'vytvořeno',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => auth('customer')->user()->id,
            'invoice' => 'bude doplněno'

        ]);

   
            
        try {
            Event::create([
                'id' => 'eventid'.$newOrder->id,
                'name' => 'Číslo objednávky: '.$newOrder->id,
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                ]);
          } catch (\Google_Service_Exception $e) {
            $ev = Event::find('eventid'.$newOrder->id);

            $ev->startDate = Carbon::now()->add(1, 'week');
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->status = "confirmed";
            
            $ev->save();
           
        }
             



            $orders = Order::get();
        if(auth('customer')->user()) {
            $customer = Customer::find(auth('customer')->user()->id);
       
            return back();
        } else {
            
            $orders = Order::get();

            return view('orders.index', [
                'orders' => $orders,
            ]);
        }
    }

    public function myindex($id)
    {

        $customer = Customer::find($id);
      
        $events = Event::get();

      
        
        
        return view('orders.index', [
            'orders' => $customer->order,
            
        ]);
    }

    public function indexFilter(Request $request)
    {
        
        if(auth('customer')->user()) {
            
            $orders = Order::get()->where('id', '=', $request->input('query'))->where('customer_id', '=', auth('customer')->user()->id);
        } else {
            
            $orders = Order::get()->where('id', '=', $request->input('query'));
        }
        

        
        if($orders->isEmpty()) {
            return back()->with('error', 'Objednávka nenalezena.');
        }

        return view('orders.index', [
            'orders' => $orders,
            
        ]);
    }

    public function index()
    {

        $orders = Order::get();
        $events = Event::get();

        

        /*foreach($orders as $order) {
            $order->delete();
        }
        foreach($events as $event) {
            $event->delete();
        }
*/

        $data = Order::select('id', 'created_at')->get()->groupBy(function($data) {
           return  Carbon::parse($data->created_at)->format('M');
        });

  
        $orders = Order::orderBy('term', 'ASC')->get();
        
        return view('orders.index', [
            'orders' => $orders,
            'data' => $data
           
            
        ]);

    }

    public function getProductsByOrder()
    {
        $pole = array();

        $polesmall = array();
 
        $allItems = Item::orderBy('order_id')->get();

        if($allItems->isEmpty()) {
            return $pole;
        }

       $first = $allItems[0]->order_id;
        $lastItem = Item::get()->last();
       
            foreach($allItems as $oneItem) {
                if($first == $oneItem->order_id) {
                    if($oneItem->is_mixed == "ano") {
                        array_push($polesmall, $oneItem->productMixed->code);
                    } else {
                        array_push($polesmall, $oneItem->productOriginal->code);
                    }
                    if($lastItem->id == $oneItem->id) {
                        array_push($pole, $polesmall);
                    }
                } else {
                    
                    $first = $oneItem->order_id;
                   
                    array_push($pole, $polesmall);
                    $polesmall = array();
                    
                    if($oneItem->is_mixed == "ano") {
                        array_push($polesmall, $oneItem->productMixed->code);
                    } else {
                        array_push($polesmall, $oneItem->productOriginal->code);
                    }
                }
            }
     
        return $pole;
        

       // dd($associator->predict(['O-L-155','M-C-10000']));
       //dd($associator->apriori());
    }

    public function calculateApriori(Order $order)
    {
        $samples = self::getProductsByOrder();
        
        $labels = [];
        $associator = new Apriori($support = 0.6, $confidence = 0.5);
        $associator->train($samples, $labels);

        $itemsInOrder = array();

        foreach($order->item as $one) {
            if($one->is_mixed == "ano") {
         
                array_push($itemsInOrder, $one->productMixed->code);
            } else {
                array_push($itemsInOrder, $one->productOriginal->code);
            }
            
        }
      
       $recommendedItems = array();
       if (empty($itemsInOrder)) {
       
        } else {
            $recommendedItems = $associator->predict($itemsInOrder);
        }

  
        return $recommendedItems;
    }

    public function show($id)
    {
        $order = Order::find($id);

        $items = $order->item;

        $allItems = Item::get();
     
        $recommendedItems = array();
        $recommendedItems = self::calculateApriori($order);

        
      
       //dd($associator->apriori());

        return view('orders.show', [
            'recommended' => $recommendedItems,
            'order' => $order,
            'items' => $items,
            'allItems' => $allItems
        ]);
    }
    
    
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        $events = Event::get();
        
    

        $event = Event::find('eventid'.$order->id);
        $event->delete();

        

        $orders = Order::get();

        return view('orders.index', [
            'orders' => $orders,
            
        ]);
    }

    public function changeState($orderId, Request $request)
    {
        $order = Order::find($orderId);


        $this->validate($request, [
            'state' => 'required', 
        ]);
        $order->state = $request->state;
        $order->save();

        return back();
    }

    public function edit($orderId)
    {

        $order = Order::Find($orderId);

        return view('orders.edit', [
            'order' => $order
        ]);
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::Find($orderId);


        $this->validate($request, [
            'state' => 'required',
            'term' =>'required|date',
        ]);

        $order->term = $request->term;
        $order->state = $request->state;
        $order->invoice = 'bude doplněno';

        $order->save();

        $orders = Order::get();

        try {
            $event = Event::find('eventid'.$orderId);
          } catch (\Google_Service_Exception $e) {
            Event::create([
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return view('orders.index', [
                'orders' => $orders,
                
            ]);
          }
        
          $event->startDate = Carbon::createFromDate($request->term);
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();


        return view('orders.index', [
            'orders' => $orders,
            
        ]);
        
    }

    public function changeTerm(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        

        $this->validate($request, [
            'term' => 'required', 
        ]);


        $order->term = $request->term;
        $order->save();

        try {
            $event = Event::find('eventid'.$orderId);
          } catch (\Google_Service_Exception $e) {
            Event::create([
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return back();
          }
        
          $event->startDate = Carbon::createFromDate($request->term);
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();
          /*
        Event::create([
            'id' => 'eventid'.$orderId,
            'name' => 'Číslo objednávky: '.$orderId,
            'startDate' => Carbon::createFromDate($request->term),
            'endDate' => Carbon::createFromDate($request->term),
         ]);
  
*/
      //  $event->save();
/*
        $e = Event::get();

        dd($e);*/

        return back();
    }

    public function storeAdmin($subId)
    {
        $newOrder = Order::create([
            'state' => 'založeno',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => $subId,
            'invoice' => 'bude doplněno'
        ]);
        
        
        try {
            Event::create([
                'id' => 'eventid'.$newOrder,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$newOrder,
                'description' => 'založeno',
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                
            
             ]);
        } catch (\Google_Service_Exception $e) {
            $ev = Event::find('eventid'.$newOrder->id);
            $ev->status = "confirmed";
            $ev->startDate = Carbon::now()->add(1, 'week');
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->save();
        
        }
        
        
        

        return redirect()->route('orders.index');


        
    }

    public function uploadFile(Request $request, $orderId)
    {
        if($request->hasFile('invoice')){
            $path = 'public/invoices';
            $invoice = $request->file('invoice');
            $invoice_name = $invoice->getClientOriginalName();
            $fullPath = $request->file('invoice')->storeAs($path, $invoice_name);
            
        
            $input['invoice'] = $invoice_name;
        } else {
            return back();
        }
        
        $order = Order::find($orderId);

        $order->invoice = $invoice_name;
        $order->save();
       
        return back();
    }

    
}
