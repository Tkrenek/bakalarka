<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Stats extends Authenticatable
{
    use HasFactory;
    use Notifiable;

   
     public static function getSum($pole)
    {
        $sum = 0;
        foreach($pole as $bal) {
            $sum += $bal->count;
        }

        return $sum;
    }

    public static function getMaxFrom($pole, $pocet)
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

    public static function getResultsOriginal() {
        $resultsOriginal = DB::table('items')->where('is_mixed', 'ne')->sum('amount');
 
         return $resultsOriginal;
     }

     public static function getResultsMixed() {

        $resultsMixed = DB::table('items')->where('is_mixed', 'ano')->sum('amount');
     
        return $resultsMixed;
    }

    public static function getCustomerMax()
    {
        $zakaznici = DB::select(DB::raw('select customers.name, count(customer_id) as "count" from orders join customers on customers.id = orders.customer_id group by customers.name'));
        $nejvic = Stats::getMaxFrom($zakaznici, 5);

        return $nejvic;
    }

    public static function getEmployeesMax()
    {
        $zamestnanci = DB::select(DB::raw('select CONCAT(employees.name, " ",employees.surname)  as "name", sum(order_works.time) as "count" from order_works join employees on employees.id = order_works.employee_id group by employees.name, employees.surname'));
        $zamestnanci = Stats::getMaxFrom($zamestnanci, 5);

        return $zamestnanci;
    }


    public static function getContainersMax()
    {
        $baleni = DB::select(DB::raw('select containers.code, sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code'));
        $baleni = Stats::getMaxFrom($baleni, 5);

        return $baleni;
    }

    public static function getBaleniKanistr()
    {
        $baleniPomer1 = DB::select(DB::raw('select  sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code having containers.code like "K%"'));
        $baleniPomer1 = Stats::getSum($baleniPomer1);

        return $baleniPomer1;
    }

    public static function getBaleniPlech()
    {
        $baleniPomer2 = DB::select(DB::raw('select  sum(package_items.count) as "count" from package_items join containers on containers.id = package_items.container_id group by containers.code having containers.code like "P%"'));
        $baleniPomer2 = Stats::getSum($baleniPomer2);

        return $baleniPomer2;
    }

    public static function getProduktyOriginal()
    {
        $produktyOrig = DB::select(DB::raw('select items.is_mixed, product_originals.code, sum(items.amount) as "count" from items join product_originals on product_originals.id = items.product_original_id group by product_originals.code, items.is_mixed having items.is_mixed = "ne"'));

        return $produktyOrig;
    }

    public static function getProduktyMixed()
    {
        $produktyOrig = DB::select(DB::raw('select items.is_mixed, product_mixeds.code, sum(items.amount) as "count" from items join product_mixeds on product_mixeds.id = items.product_mixed_id group by product_mixeds.code, items.is_mixed having items.is_mixed = "ano"'));

        return $produktyOrig;
    }

    public static function mergeProducts($produktyOrig, $produktyMixed)
    {
        $maximaProdukty = array();
        foreach($produktyMixed as $pm) {
            array_push($maximaProdukty, $pm);
        }
        foreach($produktyOrig as $po) {
            array_push($maximaProdukty, $po);
        }

        return $maximaProdukty;
    }

   


    


    
}