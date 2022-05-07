<?php
/**
 * Nazev souboru: DepartmentController.php
 * Controller pro oddeleni
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
     /**
     * Vraci pohled s formularem pro vytvoreni noveho oddeleni
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('departments.create'); // vraci pohled
    }


    public function index()
    {
        $departments = Department::get();

        
        
        // vraci pohled
        return view('departments.index', [
            'departments' => $departments
        ]);
    }

     /**
     * Ulozi novy zaznam s oddelenim v databazi
     * 
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        // overeni udaju z formulare
        $this->validate($request, [
            'name' => 'required|unique:departments',
        ]);

        // vytvoreni oddeleni
        Department::create([
            'name' => $request->name,
        ]);

        return redirect()->route('departments.index');
    }
    
    public function destroy($id)
    {
        $deparment = Department::find($id);

        $deparment->delete();

        return back();
    }
}
