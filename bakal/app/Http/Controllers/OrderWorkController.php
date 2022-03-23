<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderWork;

class OrderWorkController extends Controller
{
    public function create($orderId)
    {
        $order = Order::find($orderId);

        return view('orderwork.create', [
            'order' => $order
        ]);
    }

    public function store(Request $request, $orderId)
    {
        $this->validate($request, [
            'type' => 'required',
            'time' => 'required',
            'date' => 'required',
            
        ]);
        

        OrderWork::create([
            'order_id' => $orderId,
            'employee_id' => auth('employee')->user()->id,
            'work_type' => $request->type,
            'time' => $request->time,
            'date' => $request->date,

        ]);

        

        return back();
    }

    public function index()
    {
        
        $orderworks = OrderWork::get();

        return view('orderwork.index', [
            'orderworks' => $orderworks
        ]);
    }

    public function destroy($id)
    {
        $orderWokrk = OrderWork::find($id);
        $orderWokrk->delete();



        return back();
    }
}
