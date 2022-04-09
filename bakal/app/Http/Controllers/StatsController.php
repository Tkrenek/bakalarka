<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class StatsController extends Controller
{
    public function getMaxFrom($pole, $pocet)
    {
        $nejvic = array();
        
        $counts = array();

        foreach($pole as $zak) {
            array_push($counts, $zak->count);
        }

     
        for($i = 0; $i < $pocet; $i++) {
            if(empty($counts)) {
                break;
            }
            $key = array_search(max($counts), $counts);

            array_push($nejvic, $pole[$key]);
            
            unset($pole[$key]);
            unset($counts[$key]);
        }
        
        
        
       

        return $nejvic;
    }

    public function index()
    {
        $resultsOriginal = DB::table('items')->where('is_mixed', 'ne')->count('*');
       
        $resultsMixed = DB::table('items')->where('is_mixed', 'ano')->count('*');

     
        
        $zakaznici = DB::select(DB::raw('select customers.name, count(customer_id) as "count" from orders join customers on customers.id = orders.customer_id group by customers.name'));
    

        $nejvic = self::getMaxFrom($zakaznici, 2);

   
        $zamestnanci = DB::select(DB::raw('select CONCAT(employees.name, " ",employees.surname)  as "name", sum(order_works.time) as "count" from order_works join employees on employees.id = order_works.employee_id group by employees.name, employees.surname'));

       
        $zamestnanci = self::getMaxFrom($zamestnanci, 3);
        
        
      
       

        return view('stats.index', compact('resultsOriginal', 'resultsMixed', 'nejvic', 'zamestnanci'));
    }
}
