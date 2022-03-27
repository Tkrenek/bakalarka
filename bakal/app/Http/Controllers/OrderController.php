<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\File;
use App\Models\Item;
use App\Models\Subscriber;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class OrderController extends Controller
{
   
    public function store()
    {
       
        Order::create([
            'state' => 'created',
            'term' => Carbon::now()->add(1, 'week'),
            'subscriber_id' => auth('subscriber')->user()->id,
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

        if(auth('subscriber')->user()) {
            $subscriber = Subscriber::find(auth('subscriber')->user()->id);
       
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

        $subscriber = Subscriber::find($id);
      
        
        return view('orders.index', [
            'orders' => $subscriber->order,
            
        ]);
    }

    public function index()
    {
        $orders = Order::orderBy('term', 'ASC')->get();
        
        return view('orders.index', [
            'orders' => $orders,
            
        ]);
    }

    public function show($id)
    {
        $order = Order::find($id);

        $items = $order->item;

     
        return view('orders.show', [
            'order' => $order,
            'items' => $items
        ]);
    }
    
    
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();


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
        Order::create([
        'state' => 'založeno',
        'term' => Carbon::now()->add(1, 'week'),
        'subscriber_id' => $subId,
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
             return view('orders.index', [
                'orders' => $orders,
                
            ]);
        
        

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
