<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderWork;
use App\Models\Employee;

class OrderWorkController extends Controller
{
    public function create($orderId)
    {
        $order = Order::find($orderId);

        return view('orderwork.create', [
            'order' => $order
        ]);
    }

    public function  createAsAdmin($emplId)
    {
        $employee = Employee::find($emplId);

        return view('orderwork.create', [
            'employee' => $employee
        ]);
    }
   
    public function store(Request $request, $orderId)
    {
        $this->validate($request, [
            'type' => 'required',
            'time' => 'required|numeric|min:1',
            'date' => 'required',
            
        ]);
        

        OrderWork::create([
            'order_id' => $orderId,
            'employee_id' => auth('employee')->user()->id,
            'work_type' => $request->type,
            'time' => $request->time,
            'date' => $request->date,

        ]);

        

        return redirect()->route('orders.index');
    }

    public function storeAsAdmin(Request $request, $emplId)
    {
        $this->validate($request, [
            'order' => 'required|numeric',
            'type' => 'required',
            'time' => 'required',
            'date' => 'required',
            
        ]);
        
        $employee = Employee::find($emplId);

        OrderWork::create([
            'order_id' => $request->order,
            'employee_id' => $employee->id,
            'work_type' => $request->type,
            'time' => $request->time,
            'date' => $request->date,

        ]);

        

        return redirect()->route('orderWork.index');
    }

    public function index()
    {
        
        

        if(auth('employee')->user()){
            
            return view('orderwork.index', [
                'orderworks' => auth('employee')->user()->orderWork
            ]);
        }
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
