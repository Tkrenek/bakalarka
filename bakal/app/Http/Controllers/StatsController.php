<?php
/**
 * Nazev souboru: StatsContoller.php
 * Controller pro zobrazeni statistik
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stats;

use DB;

class StatsController extends Controller
{

    /**
     * Metoda pro osetreni deleni nulou
     * inspirace z: https://stackoverflow.com/questions/32755983/avoid-the-divide-by-zero-error-laravel-framework
     */
    public function divnum($cislo1, $cislo2)
    {
        return $cislo2 == 0 ? 0 : ($cislo1 / $cislo2);
    }

  
    /**
     * Hlavni metoda, která získává analyzovaná data z modelu Stats.php a posila je pohledu pro zobrazeni
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $resultsOriginal = Stats::getResultsOriginal(); // pocet polozek originalnich produktu
        $resultsMixed = Stats::getResultsMixed(); // pocet polozek michanych produktu
        $celkemProdukty = $resultsMixed + $resultsOriginal; // celkovy pocet
    
        // ziskani procent z celkoveh poctu
        $resultsMixed = self::divnum($resultsMixed,$celkemProdukty) * 100; 
        $resultsOriginal = self::divnum($resultsOriginal,$celkemProdukty) * 100;

        // nejvetsi zakaznici
        $nejvic = Stats::getCustomerMax();
   
        // nejpilnejsi zamestnanci
        $zamestnanci = Stats::getEmployeesMax();

        // nejcastejsi baleni
        $baleni = Stats::getContainersMax();
       
        
        $baleniPomer1 = Stats::getBaleniKanystr(); // pocet kanystru
        $baleniPomer2 = Stats::getBaleniPlech(); // pocet plechovek
        $celkem = $baleniPomer1 + $baleniPomer2; // celkovy pocet
        
        // vypocet procent 
        $baleniPomer1 = self::divnum($baleniPomer1, $celkem) * 100;
        $baleniPomer2 = self::divnum($baleniPomer2, $celkem) * 100;

        // ziskani vsech produktu
        $produktyOrig = Stats::getProduktyOriginal();
        $produktyMixed = Stats::getProduktyMixed();

        // spojeni produktu
        $merged = Stats::mergeProducts($produktyOrig, $produktyMixed);
        
        // nalezeni nejprodavanejsich produktu
        $maximaProdukty = Stats::getMaxFrom($merged, 5);
        
        // pohled pro zobzeni statistik
        return view('stats.index', compact(
            'resultsOriginal',
            'resultsMixed',
            'nejvic',
            'zamestnanci',
            'baleni',
            'baleniPomer1',
            'baleniPomer2',
            'maximaProdukty'
        ));
    }
}
