<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Vraci pohled s formularem pro pridani zamestnance
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::get(); // vyhledani vsech oddeleni

        // vrati pohled s formularem
        return view('employees.create', [
            'departments' => $departments
        ]);
    }

    /**
     * Vraci pohled se vsemi zamestnanci
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employees = Employee::get(); // vyhleda vsechny zamestnance

        // vrati pohled se zamestnanci
        return view('employees.index', [
            'employees' => $employees
        ]);

    }

    /**
     * Vraci pohled s formularem pro upravu udaju o zamestnanci
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $employee = Employee::where('id', $id)->first(); // vyhleda zamestnance podle jeho ID

        // vrati pohled se zamestnanci
        return view('employees.update', [
            'employee' => $employee
        ]);


    }

    /**
     * Aktualizuje udaje zamestnance v databazi
     * @param Illuminate\Http\Request
     */
    public function update(Request $request, $id)
    {
    
        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'function' =>'required',
        ]);
 
        $empl = Employee::find($id); // vyhledani zamestnance podle jeho ID


        // uprava udaju zamestnance
        $empl->name = $request->name;
        $empl->surname = $request->surname;
        $empl->phone = $request->phone;
        $empl->email = $request->email;
        $empl->function = $request->function;        
        $empl->birth_date = $request->birth_date;

        $empl->save(); // ulozeni do databaze

        // pokud je prihlasen zamestnanec, zobrazi se mu uvodniobrazovka
        if(auth('employee')->user()) {
            return view('employees/welcome');
        }

        return redirect()->route('employees.index'); // presmerovani na vsechny zamestnance
      
    }

    /**
     * Odstrani zaznam o zamestnanci z databaze
     */
    public function destroy($id)
    {

        $empl = Employee::find($id); // vyhleda zamestnance pomoci ID
        $empl->delete(); // odstrani zamestnance

        return back(); // vrati zpet
    }


    /**
     * Ulozi zaznam o zamestnanci do databaze
     * @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // overi udaje z formulare
        $this->validate($request, [
           'name' => 'required',
            'surname' =>'required',
            'phone' => 'required|numeric|unique:employees',
            'email' => 'required|email|unique:employees',
            'password' => 'required|confirmed',
            'function' =>'required',
            'birth_date' => 'required'
            
            
        ]);

        $department = Department::where('name', $request->department)->first(); // vyhledame oddeleni podle nazvu
  
        // vytvorime noveho zamestnance
        Employee::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'function' => $request->function,
            'birth_date' => $request->birth_date,
            'department_id' => $department->id,
        ]);

        
        return redirect()->route('employees.index'); // presmerovani
    
    }

    /**
     * Vraci pohled s formulare pro zmenu hesla
     * @return \Illuminate\View\View
     */
    public function changePassword()
    {
        return view('employees.change_password');
    }

    /**
     * Zmeni heslo v databazi
     * @param Illuminate\Http\Request
     */
    public function updatePassword(Request $request, $id)
    {

        $employee = Employee::find($id); // vyhledani zamestnance podle ID
        
        // overeni dat z formulare
        $this->validate($request, [
            'password_old' => 'required',
            'password' => 'required|confirmed',
         
        ]);

        // kontrola hesla
        if(Hash::check($request->password_old, $employee->password)) {
            $employee->password = Hash::make($request->password); // zmena hesla
            $employee->save();
            return back()->with('success', 'Heslo úspěšně změněno');
        } else {
            return back()->with('error', 'Zadáno chybné staré heslo'); // chybove hlaseni
        }

    }

    /**
     * Vraci pohled s formulare pro zmenu hesla z pohledu admina
     * @return \Illuminate\View\View
     */
    public function changePasswordAdmin($emplId)
    {
        $employee = Employee::find($emplId); // vyhledani zamestnance podle ID

        // pohled s formularem pro zmenu hesla
        return view('employees.change_passwordAdmin', [
            'employee' => $employee
        ]);
    }
    
    /**
     * Zmeni heslo v databazi z pohledu admina
     * @param Illuminate\Http\Request
     */
    public function updatePasswordAdmin(Request $request, $id)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'password' => 'required|confirmed',
         
        ]);

        $employee = Employee::find($id); // vyhledani zamestnance podle ID
        $employee->password = Hash::make($request->password); // zmena hesla
        $employee->save();
           
       
        return back()->with('success', 'Heslo úspěšně změněno'); // uspesne vypsani hlasky
        
    }



}
