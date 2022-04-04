<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\File;
use App\Models\Item;
use App\Models\Customer;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Phpml\Association\Apriori;



class OrderController extends Controller
{
   
    public function store()
    {
       
        
        Order::create([
            'state' => 'created',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => auth('customer')->user()->id,
            'invoice' => 'bude doplněno'

        ]);

        $orders = Order::get();
        $lastId = Order::get()->last()->id;
   
            
        Event::create([
            'id' => 'eventid'.$lastId,
            'name' => 'Číslo objednávky: '.$lastId,
            'startDate' => Carbon::now()->add(1, 'week'),
            'endDate' => Carbon::now()->add(1, 'week'),
            ]);
            return redirect()->route('orders.index');
/*
            return view('orders.index', [
            'orders' => $orders,
                    
            ]);
  */      


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
      
        
        return view('orders.index', [
            'orders' => $customer->order,
            
        ]);
    }

    public function index()
    {

        
        $orders = Order::orderBy('term', 'ASC')->get();
        
        return view('orders.index', [
            'orders' => $orders,
            
        ]);
    }


    public function getFrequented()
    {
        $pole = array();

        $polesmall = array();
 
        $allItems = Item::orderBy('order_id')->get();

        if($allItems->isEmpty()) {
            return $pole;
        }

        /*
        array_push($polesmall, 1);
        array_push($polesmall, 23);

        array_push($pole, $polesmall);

        $polesmall = array();

        array_push($polesmall, 0);
        array_push($polesmall, 5);

        array_push($pole, $polesmall);

        dd($pole);*/
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

    public function show($id)
    {
        $order = Order::find($id);

        $items = $order->item;

        $allItems = Item::get();
     

        $samples = self::getFrequented();
        
    
        $labels = [];
        $associator = new Apriori($support = 0.5, $confidence = 1);
      //  $samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta']];
        $associator->train($samples, $labels);

        $arrayOfThisItems = array();

        foreach($order->item as $one) {
            if($one->is_mixed == "ano") {
         
                array_push($arrayOfThisItems, $one->productMixed->code);
            } else {
                array_push($arrayOfThisItems, $one->productOriginal->code);
            }
            
        }

       // dd($arrayOfThisItems);
       // dd($arrayOfThisItems);
       $recommendedItems = array();
       if (empty($arrayOfThisItems)) {
       
        } else {
            $recommendedItems = $associator->predict($arrayOfThisItems);
        }
        
      
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


        $event = Event::find('eventid'.$order->id);
        $event->delete();

        $orders = Order::get();

        $events = Event::get();

   

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
               // 'addAttendee' => ['email' => 'kreny48@gmail.com']
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
                //'addAttendee' => ['email' => 'kreny48@gmail.com']
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
        Order::create([
        'state' => 'založeno',
        
        'term' => Carbon::now()->add(1, 'week'),
        'customer_id' => $subId,
        'invoice' => 'bude doplněno'
    ]);


    $orders = Order::get();
    $lastId = Order::get()->last()->id;

        
            Event::create([
                'id' => 'eventid'.$lastId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$lastId,
                'description' => 'založeno',
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                //'addAttendee' => ['email' => 'kreny48@gmail.com']
             ]);

             
             return redirect()->route('orders.index');
        
        

    return redirect()->route('orders.index');


        
    }

    public function uploadFile(Request $request)
    {
        $size = $request->file('invoice')->getSize();
        $name = $request->file('invoice')->getClientOriginalName();

        $request->file('invoice')->store('public/images/');
        $file = new App\Models\File();
        $file->name = $name;
        $file->size = $size;
        $file->save();
        return back();
    }

    
}
