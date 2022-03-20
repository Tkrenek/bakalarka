<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderWork;

class OrderWorkController extends Controller
{
    public function create()
    {
        $orders = Order::get();

        return view('orderwork.create', [
            'orders' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'order' => 'required',
            'time' => 'required',
            'date' => 'required',
            
        ]);
        

        OrderWork::create([
            'order_id' => $request->order,
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
}
