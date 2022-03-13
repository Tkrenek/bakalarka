<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;

class RegisterEmployeeController extends Controller
{
    public function index()
    {
        $departments = Department::get();
        return view('employees.create', [
            'departments' => $departments
        ]);
       
    }

    public function store(Request $request)
    {
    
    $this->validate($request, [
           'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:employees',
            'password' => 'required|confirmed',
            'function' =>'required',
            'login' =>'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            
            
        ]);
        $department = Department::where('name', $request->department)->first();

        $dt = Carbon::create($request->year, $request->month, $request->day);
  
        Employee::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'function' => $request->function,
            'login' => $request->login,
            'birth_date' => $dt->toDateString(),
            'department_id' => $department->id,

        ]);

        /*$data = $request->only('email', 'password');
 
        if (Auth::guard('employee')::attempt($data)) {
            // Authentication passed...
            return redirect()->intended('containers.index');
        }*/



        

        return back();
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}