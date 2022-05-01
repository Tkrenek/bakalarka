<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stats;

use DB;

class StatsController extends Controller
{

    public function index()
    {
        $resultsOriginal = Stats::getResultsOriginal();
        $resultsMixed = Stats::getResultsMixed();
        $celkemProdukty = $resultsMixed + $resultsOriginal;
        
        try {
            $resultsMixed /= $celkemProdukty / 100;
            $resultsOriginal /= $celkemProdukty / 100;
        }catch(Exception $e){
            $resultsMixed = 0;
            $resultsOriginal = 0;
        }
        

     
        $nejvic = Stats::getCustomerMax();

   
        $zamestnanci = Stats::getEmployeesMax();


        $baleni = Stats::getContainersMax();
       


        $baleniPomer1 = Stats::getBaleniKanistr();
        $baleniPomer2 = Stats::getBaleniPlech();
        $celkem = $baleniPomer1 + $baleniPomer2;

        try{
            $baleniPomer1 /= $celkem / 100;
            $baleniPomer2 /= $celkem / 100;
        } catch(Exception $e){
            $baleniPomer1 = 0;
            $baleniPomer2 = 0;
        }
        


        $produktyOrig = Stats::getProduktyOriginal();
        $produktyMixed = Stats::getProduktyMixed();
      


        $merged = Stats::mergeProducts($produktyOrig, $produktyMixed);
        
        

        $maximaProdukty = Stats::getMaxFrom($merged, 3);


        
        return view('stats.index', compact('resultsOriginal', 'resultsMixed', 'nejvic', 'zamestnanci', 'baleni', 'baleniPomer1', 'baleniPomer2', 'maximaProdukty'));
    }
}
