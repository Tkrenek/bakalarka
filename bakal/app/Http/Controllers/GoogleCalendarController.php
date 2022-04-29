<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
     /**
     * Vraci pohled s pokyny pro pridani google kalendare
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('google.index');
    }
}
