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

    public function getSum($pole)
    {
        $sum = 0;
        foreach($pole as $bal) {
            $sum += $bal->count;
        }

        return $sum;
    }

    public function index()
    {
        $resultsOriginal = DB::table('items')->where('is_mixed', 'ne')->count('*');

        $resultsMixed = DB::table('items')->where('is_mixed', 'ano')->count('*');

     
        $zakaznici = DB::select(DB::raw('select customers.name, count(customer_id) as "count" from orders join customers on customers.id = orders.customer_id group by customers.name'));
        $nejvic = self::getMaxFrom($zakaznici, 3);

   
        $zamestnanci = DB::select(DB::raw('select CONCAT(employees.name, " ",employees.surname)  as "name", sum(order_works.time) as "count" from order_works join employees on employees.id = order_works.employee_id group by employees.name, employees.surname'));
        $zamestnanci = self::getMaxFrom($zamestnanci, 3);


        $baleni = DB::select(DB::raw('select containers.code, sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code'));
        $baleni = self::getMaxFrom($baleni, 3);
       

        $baleniPomer1 = DB::select(DB::raw('select  sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code having containers.code like "K%"'));
        $baleniPomer2 = DB::select(DB::raw('select  sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code having containers.code like "P%"'));

        $baleniPomer1 = self::getSum($baleniPomer1);
        $baleniPomer2 = self::getSum($baleniPomer2);


        $produktyOrig = DB::select(DB::raw('select product_originals.code, sum(items.amount) as "count" from items join product_originals on product_originals.id = items.product_original_id group by product_originals.code'));
        $produktyMixed = DB::select(DB::raw('select product_mixeds.code, sum(items.amount) as "count" from items join product_mixeds on product_mixeds.id = items.product_mixed_id group by product_mixeds.code '));
       
        dd($produktyOrig);

        
        return view('stats.index', compact('resultsOriginal', 'resultsMixed', 'nejvic', 'zamestnanci', 'baleni', 'baleniPomer1', 'baleniPomer2'));
    }
}
