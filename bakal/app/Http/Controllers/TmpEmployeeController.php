<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::get();


        return view('employees.index', [
            'employees' => $employees
        ]);

    }

    public function edit($id)
    {
        $employee = Employee::where('id', $id)->first();
        return view('employees.update', [
            'employee' => $employee
        ]);


    }

    

    public function update(Request $request, $id)
    {
    
   
    $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
    
            'function' =>'required',
   
            
        ]);
 
        //$dt = Carbon::create($request->year, $request->month, $request->day);

    

        $empl = Employee::find($id);

        $empl->name = $request->name;
        $empl->surname = $request->surname;
        $empl->phone = $request->phone;

        $empl->email = $request->email;
        $empl->function = $request->function;        
      
        $empl->birth_date = $request->birth_date;

    

        $empl->save();
        if(auth('employee')) {
            return view('employees/welcome');
        }
        $employees = Employee::get();
        return view('employees.index', [
            'employees' => $employees
        ]);
      
    }

    public function destroy($id)
    {
        $empl = Employee::find($id);
        $empl->delete();

        return back();
    }

    public function change_passwordAdmin($emplId)
    {
        $employee = Employee::find($emplId);

        return view('employees.change_passwordAdmin', [
            'employee' => $employee
        ]);
    }
    
    public function update_passwordAdmin(Request $request, $id)
    {
        # code...
    }
}

