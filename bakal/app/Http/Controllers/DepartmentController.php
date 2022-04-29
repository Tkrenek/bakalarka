<?php

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
    public function index()
    {
        return view('departments.create'); // vraci pohled
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

        return back();
    }
}
