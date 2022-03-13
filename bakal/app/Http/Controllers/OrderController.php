<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Item;
use App\Models\Subscriber;

class OrderController extends Controller
{
   
    public function store()
    {

        Order::create([
            'state' => 'created',
            'term' => '2000-01-01',
            'subscriber_id' => auth('subscriber')->user()->id,
            'invoice' => 'wait'

        ]);

        $orders = Order::get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
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
        $orders = Order::get();
        
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
            'invoice' => 'required', 
        ]);

        $order->term = $request->term;
        $order->state = $request->state;
        $order->invoice = $request->invoice;

        $order->save();

        $orders = Order::get();

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

        return back();
    }

    
}
