<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class StatsController extends Controller
{
    public function index()
    {
        $resultsOriginal = DB::table('items')->where('is_mixed', 'ne')->count('*');
       
        $resultsMixed = DB::table('items')->where('is_mixed', 'ano')->count('*');

     
        
        $zakaznici = DB::select(DB::raw('select customers.name, count(customer_id) as "count" from orders join customers on customers.id = orders.customer_id group by customers.name'));
     
  
        /*
        $nejprodavanejsi = DB::table('items')->where('is_mixed', 'ano')->count('*')->max();
        SELECT MAX (mycount) 
FROM (SELECT agent_code,COUNT(agent_code) mycount 
FROM orders 
GROUP BY agent_code);
        dd($nejprodavanejsi);
*/
        return view('stats.index', compact('resultsOriginal', 'resultsMixed', 'zakaznici'));
    }
}
