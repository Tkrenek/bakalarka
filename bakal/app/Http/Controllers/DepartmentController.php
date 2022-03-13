<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments',
            
        ]);

        Department::create([
            'name' => $request->name,
            

        ]);

        return back();
    }
}
