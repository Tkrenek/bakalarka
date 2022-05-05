<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stats;

use DB;

class StatsController extends Controller
{


        public function divnum($numerator, $denominator)
        {
            return $denominator == 0 ? 0 : ($numerator / $denominator);
        }

  

    public function index()
    {
        $resultsOriginal = Stats::getResultsOriginal();
        $resultsMixed = Stats::getResultsMixed();
        $celkemProdukty = $resultsMixed + $resultsOriginal;
    
        
        $resultsMixed = self::divnum($resultsMixed,$celkemProdukty) * 100;
        $resultsOriginal = self::divnum($resultsOriginal,$celkemProdukty) * 100;

        $nejvic = Stats::getCustomerMax();

   
        $zamestnanci = Stats::getEmployeesMax();


        $baleni = Stats::getContainersMax();
       


        $baleniPomer1 = Stats::getBaleniKanistr();
        $baleniPomer2 = Stats::getBaleniPlech();
        $celkem = $baleniPomer1 + $baleniPomer2;

  
        
        $baleniPomer1 = self::divnum($baleniPomer1, $celkem) * 100;
        $baleniPomer2 = self::divnum($baleniPomer2, $celkem) * 100;

        $produktyOrig = Stats::getProduktyOriginal();
        $produktyMixed = Stats::getProduktyMixed();
      


        $merged = Stats::mergeProducts($produktyOrig, $produktyMixed);
        
        

        $maximaProdukty = Stats::getMaxFrom($merged, 5);


        
        return view('stats.index', compact('resultsOriginal', 'resultsMixed', 'nejvic', 'zamestnanci', 'baleni', 'baleniPomer1', 'baleniPomer2', 'maximaProdukty'));
    }
}
