<?php
/**
 * Nazev souboru: OrderController.php
 * Controller pro praci s objednavkami
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
//use App\Models\File;
use App\Models\Item;
use App\Models\Customer;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Phpml\Association\Apriori;

use DB;

class OrderController extends Controller
{
    /**
     * Vytvori v databazi zaznam o nove objednavce
     * @throws Google_Service_Exception
     */
    public function store()
    {

        // vytvoreni nove objednavky
        $newOrder = Order::create([
            'state' => 'vytvořeno',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => auth('customer')->user()->id,
            'invoice' => 'bude doplněno'
        ]);

        try {
            // vytvoreni nove udalosti v google kalendari
            // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
            Event::create([
                'id' => 'eventid'.$newOrder->id,
                'name' => 'Číslo objednávky: '.$newOrder->id,
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                ]);

          } catch (\Google_Service_Exception $e) { // zachyceni vyjimky, pokud jiz udalost existuje

            $ev = Event::find('eventid'.$newOrder->id); // vyhledame udalost podle id

            // upravime parametry
            // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
            $ev->startDate = Carbon::now()->add(1, 'week');
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->status = "confirmed";
            
            $ev->save(); // ulozime
        }
             

        $orders = Order::get(); // vyhledame vsechny objednavky

        // pokud je prihlasen zakaznik
        if(auth('customer')->user()) {
            $customer = Customer::find(auth('customer')->user()->id);
            return redirect()->route('orders.myindex',  auth('customer')->user()->id );
        } else { // pokud je prihlasen admin, vratime pohled se vsemi objednavkami
            
            return redirect()->route('orders.index');
        }
    }

    /**
     * Vraci pohled s objednavkami prihlaseneho zakaznika
     * @return \Illuminate\View\View
     */
    public function myindex($id)
    {

        $customer = Customer::find($id); // vyhledani zakaznika podle ID

        // vraceni pohledu
        return view('orders.index', [
            'orders' => $customer->order,
            
        ]);
    }

    /**
     * Zobrazeni pohledu s vybranou objednavkou
     * @return \Illuminate\View\View
     */
    public function indexFilter(Request $request)
    {
        //  vyhledani objedadnavky podle ID
        if(auth('customer')->user()) {
            $orders = Order::get()->where('id', '=', $request->input('query'))->where('customer_id', '=', auth('customer')->user()->id);
        } else {
            
            $orders = Order::get()->where('id', '=', $request->input('query'));
        }
        
        // pokud nic neni nalezeno
        if($orders->isEmpty()) {
            return back()->with('error', 'Objednávka nenalezena.'); // chybova hlaska
        } 

        // vraceni pohledu
        return view('orders.index', [
            'orders' => $orders, 
        ]);
    }

    /**
     * Zobrazeni pohledu se vsemi objednavkami
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        $orders = Order::get(); // vyhledani vsech objednavek

        $orders = Order::orderBy('term', 'ASC')->get(); // serazen objednavek podle terminu
        
        // vraceni pohledu
        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Funkce pro seskupeni produktu podle objednavek
     * @return array - pole se produkty podle objednavek
     */
    public function getProductsByOrder()
    {
        $arr = array();
        $arrsmall = array();
 
        $allItems = Item::orderBy('order_id')->get(); // ziskani vsech polozek

        // pokud nic neni nalezeno
        if($allItems->isEmpty()) {
            return $arr;
        }

        // zjistime prvi ID objednavky
        $first = $allItems[0]->order_id;
        // zjistime posledni polozku
        $lastItem = Item::get()->last();
       
        // prochazime vsechny polozky
        foreach($allItems as $oneItem) {
            if($first == $oneItem->order_id) { // pokud je to prvni objednavka
                if($oneItem->is_mixed == "ano") { // pokud se jedna o michany produkt
                    array_push($arrsmall, $oneItem->productMixed->code); // do pole vlozime kod michaneho produktu
                } else { // pokud se jedna o originalni produkt
                    array_push($arrsmall, $oneItem->productOriginal->code); // do pole vlozime kod originalnih produktu
                } 
                // pokud je to posledni polozka
                if($lastItem->id == $oneItem->id) {
                    array_push($arr, $arrsmall);
                }
            } else { // pokud to neni prvni objednavka
                $first = $oneItem->order_id; // ziskani objednavky
                array_push($arr, $arrsmall); // vlozime mensi pole do hlavniho pole
                $arrsmall = array(); // vyprazdnime mensi pole
                if($oneItem->is_mixed == "ano") { // pokud se jedna o michany produkt
                    array_push($arrsmall, $oneItem->productMixed->code); // ulozime michany produkt
                } else { // pokud se jedna o originalni produkt
                    array_push($arrsmall, $oneItem->productOriginal->code); // ulozime originalni produkt
                }
            }
        }
        return $arr; // vratime pole
    }

    /**
     * Funkce vrati doporucene produkty pomoci metody apriori
     * PHP-ML - Machine Learning library for PHP [Source code]. https://php-ml.readthedocs.io/en/latest/machine-learning/association/apriori/.
     * @return array - pole se produkty podle objednavek
     */
    public function calculateApriori(Order $order)
    {
        $items1 = self::getProductsByOrder(); // ziskame si produkty podle objednavek pomoci sve funkce
 
        // PHP-ML - Machine Learning library for PHP [Source code]. https://php-ml.readthedocs.io/en/latest/machine-learning/association/apriori/.
        $items2 = [];
        $apriori = new Apriori($support = 0.2, $confidence = 0.2); // vytvoreni instance tridy Apriori
        $apriori->train($items1, $items2); // vytrenovani instance

        $itemsInOrder = array();

        // prochazime produkty objednavky
        foreach($order->item as $one) {
            if($one->is_mixed == "ano") { // pokud se jedna o michany produkt
                array_push($itemsInOrder, $one->productMixed->code);
            } else {
                array_push($itemsInOrder, $one->productOriginal->code);
            }
            
        }
      
        // pole pro dopoporucene polozky
        $recommendedItems = array();
        if (empty($itemsInOrder)) {
        } else {
            $recommendedItems = $apriori->predict($itemsInOrder); // predpoved doporucenych polozek
        }
    
        return $recommendedItems; // vraceni doporucenych polozek
    }

    /**
     * Metoda pro zobrazeni detailu objednavky
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::find($id); // vyhleda se objednavka podle ID

        $items = $order->item; // ziskani polozek v objednavce

        $allItems = Item::get(); // ziskani vsech polozek
     
        $recommendedItems = array(); //pole pro doporcene produkty
        $recommendedItems = self::calculateApriori($order); // zjisteni doporucenych polozek metodou Apriori

        // vraceni pohledu
        return view('orders.show', [
            'recommended' => $recommendedItems,
            'order' => $order,
            'items' => $items,
            'allItems' => $allItems
        ]);
    }
    
    /**
     * Metoda pro smazani objednavky
     */
    public function destroy($id)
    {
        $order = Order::find($id); // nalezeni objednavky podle ID
        $order->delete(); // smazani objednavky

        // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
         try {
            $event = Event::find('eventid'.$order->id); // vyhledani a smazani udalosti z google kalendare
            $event->delete();
          } catch (\Google_Service_Exception $e) { // pokud je jit udalost smzana
             return redirect()->route('orders.index'); // presmerovani
          }


          return redirect()->route('orders.index'); // presmerovani
    }

    /**
     * Zmeni stav ovbjednavky
     * @param Illuminate\Http\Request
     */
    public function changeState($orderId, Request $request)
    {
        $order = Order::find($orderId); // vyhleda objednavku podle ID

        // overi, zda byl zadan stav
        $this->validate($request, [
            'state' => 'required', 
        ]);

        $order->state = $request->state; // zmeni stav
        $order->save();

        return back();
    }

    /**
     * Zobrazi pohled s formularem pro zmenu objednavky
     * @return \Illuminate\View\View
     */
    public function edit($orderId)
    {

        $order = Order::Find($orderId); // vyhleda objednavku

        // posle pohled
        return view('orders.edit', [
            'order' => $order
        ]);
    }

    /**
     * Zmeni data o objednavce v databazi
     * @param Illuminate\Http\Request
     */
    public function update(Request $request, $orderId)
    {
        $order = Order::Find($orderId); // najde objednavku podle ID

        // overi zda byly zadany spravne udaje
        $this->validate($request, [
            'state' => 'required',
            'term' =>'required|date',
        ]);

        // zmeni udaje
        $order->term = $request->term;
        $order->state = $request->state;
        

        $order->save(); // ulozi


        // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
        try {
            $event = Event::find('eventid'.$orderId);  // vyhleda udalost v google kalendari
          } catch (\Google_Service_Exception $e) { // pokud tam udalost neni, vytvori ji znovu
            Event::create([
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return redirect()->route('orders.index'); // prsmerovani na objednavky
          }
        
          // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
          $event->startDate = Carbon::createFromDate($request->term); // zmeni udalost v google kalendari
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();


          return redirect()->route('orders.index'); // presmerovani
        
    }

    /**
     * Zmeni termin objednavky
     * @param Illuminate\Http\Request
     */
    public function changeTerm(Request $request, $orderId)
    {
        $order = Order::find($orderId); // vyhleda objednavku podle ID

        // overeni data z formulare
        $this->validate($request, [
            'term' => 'required|date', 
        ]);


        $order->term = $request->term; // zmena terminu
        $order->save();

        // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
        try {
            $event = Event::find('eventid'.$orderId); // vyhledani udalosti v google calendari
          } catch (\Google_Service_Exception $e) { // pokud udalost neni nalezena
            Event::create([ // vytvori se nova udalost v google calendari
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return back(); 
          }
        
          // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
          $event->startDate = Carbon::createFromDate($request->term); // zmena udalosti v google calendari
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();
     

        return back();
    }

    /**
     * Adminovkse vytvoreni objednavky
     */
    public function storeAdmin($subId)
    {
        // vytvoreni objednavky
        $newOrder = Order::create([
            'state' => 'založeno',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => $subId, 
            'invoice' => 'bude doplněno'
        ]);
        
        // Manage events on a Google Calendar [Source code]. https://github.com/spatie/laravel-google-calendar.
        try {
            Event::create([ // vytvoreni udalosti v google calendari
                'id' => 'eventid'.$newOrder,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$newOrder,
                'description' => 'založeno',
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
            
             ]);
        } catch (\Google_Service_Exception $e) { // pokud jiz tato udalost existuje
            $ev = Event::find('eventid'.$newOrder->id); // vyhledani udalosti
            $ev->status = "confirmed"; // pro pripad, ze udalost byla vymazana, po nastaveni na confirmed bude zase aktivni
            $ev->startDate = Carbon::now()->add(1, 'week'); // zmena udalosti
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->save();
        }
        return redirect()->route('orders.index'); // presmerovani
   
    }

    /**
     * Metoda pro nagrani faktury
     * @param Illuminate\Http\Request
     */
    public function uploadFile(Request $request, $orderId)
    {
        $order = Order::find($orderId); // vyhledani objednavky podle ID

        $date = $order->term; // ziskani aktualniho terminu objednavky

        if($request->hasFile('invoice')){ // pokud byla zadana faktura
            // ulozime fakturu
            $path = 'public/invoices'; 
            $invoice = $request->file('invoice');
            $invoice_name = $invoice->getClientOriginalName();
            $fullPath = $request->file('invoice')->storeAs($path, $invoice_name);
            
            $input['invoice'] = $invoice_name;
        } else {
            return back()->with('errorInvoice', 'Musíte nahrát fakturu.');
        }
        
        // nahrani nazvu fatury do databaze
        DB::update(DB::raw('UPDATE orders SET orders.invoice = "'.$invoice_name.'", orders.term = "'.$order->term.'"  WHERE orders.id = '.$orderId.''));


        return redirect()->route('orders.index'); // presmerovani
    }

    

    
}
