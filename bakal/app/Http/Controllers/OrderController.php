<?php

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
    public function test()
    {
        $samples = [['alpha'],
        ['alpha', 'beta', 'gamma'],
        ['alpha', 'beta', 'theta'],
        ['alpha', 'beta', 'gamma'],
        ['alpha', 'beta', 'theta'],
        ['alpha', 'beta', 'gamma'],
        ['beta', 'alpha'],
        ['alpha', 'beta', 'theta'],
        ['alpha', 'beta', 'gamma'],
        ];


        $labels  = [];



        $associator = new Apriori($support = 0.2, $confidence = 0.1);
        $associator->train($samples, $labels);


        dd($associator->predict(['alpha', 'beta']));
        
    }
    
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
            Event::create([
                'id' => 'eventid'.$newOrder->id,
                'name' => 'Číslo objednávky: '.$newOrder->id,
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                ]);

          } catch (\Google_Service_Exception $e) { // zachyceni vyjimky, pokud jiz udalost existuje

            $ev = Event::find('eventid'.$newOrder->id); // vyhledame udalost podle id

            // upravime parametry
            $ev->startDate = Carbon::now()->add(1, 'week');
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->status = "confirmed";
            
            $ev->save(); // ulozime
        }
             

        $orders = Order::get(); // vyhledame vsechny objednavky

        // pokud je prihlasen zakaznik
        if(auth('customer')->user()) {
            $customer = Customer::find(auth('customer')->user()->id);
            return back();
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
     * @return array - pole se produkty podle objednavek
     */
    public function calculateApriori(Order $order)
    {
        $items1 = self::getProductsByOrder(); // ziskame si produkty podle objednavek pomoci sve funkce
 
        $items2 = [];
        $apriori = new Apriori($support = 0.5, $confidence = 0.4); // vytvoreni instance tridy Apriori
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
      
       $recommendedItems = array();
       if (empty($itemsInOrder)) {
       
        } else {
            $recommendedItems = $apriori->predict($itemsInOrder);
        }

        return $recommendedItems;
    }

    public function show($id)
    {
        $order = Order::find($id);

        $items = $order->item;

        $allItems = Item::get();
     
        $recommendedItems = array();
        $recommendedItems = self::calculateApriori($order);

  
      


        return view('orders.show', [
            'recommended' => $recommendedItems,
            'order' => $order,
            'items' => $items,
            'allItems' => $allItems
        ]);
    }
    
    
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        $events = Event::get();
        

        
        

         try {
            $event = Event::find('eventid'.$order->id);
            $event->delete();
          } catch (\Google_Service_Exception $e) {
            
             return redirect()->route('orders.index');
          }


          return redirect()->route('orders.index');
    }

    public function changeState($orderId, Request $request)
    {
        $order = Order::find($orderId);


        $this->validate($request, [
            'state' => 'required', 
        ]);
        $order->state = $request->state;
        $order->save();

        return back();
    }

    public function edit($orderId)
    {

        $order = Order::Find($orderId);

        return view('orders.edit', [
            'order' => $order
        ]);
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::Find($orderId);


        $this->validate($request, [
            'state' => 'required',
            'term' =>'required|date',
        ]);

        $order->term = $request->term;
        $order->state = $request->state;
        

        $order->save();

        $orders = Order::get();

        try {
            $event = Event::find('eventid'.$orderId);
          } catch (\Google_Service_Exception $e) {
            Event::create([
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return view('orders.index', [
                'orders' => $orders,
                
            ]);
          }
        
          $event->startDate = Carbon::createFromDate($request->term);
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();


        return view('orders.index', [
            'orders' => $orders,
            
        ]);
        
    }

    public function changeTerm(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        

        $this->validate($request, [
            'term' => 'required', 
        ]);


        $order->term = $request->term;
        $order->save();

        try {
            $event = Event::find('eventid'.$orderId);
          } catch (\Google_Service_Exception $e) {
            Event::create([
                'id' => 'eventid'.$orderId,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$orderId,
                'startDate' => Carbon::createFromDate($request->term),
                'endDate' => Carbon::createFromDate($request->term),
               
             ]);
             return back();
          }
        
          $event->startDate = Carbon::createFromDate($request->term);
          $event->endDate = Carbon::createFromDate($request->term);
          $event->save();
     

        return back();
    }

    public function storeAdmin($subId)
    {
        $newOrder = Order::create([
            'state' => 'založeno',
            'term' => Carbon::now()->add(1, 'week'),
            'customer_id' => $subId,
            'invoice' => 'bude doplněno'
        ]);
        
        
        try {
            Event::create([
                'id' => 'eventid'.$newOrder,
                'description' => 'založeno',
                'name' => 'Číslo objednávky: '.$newOrder,
                'description' => 'založeno',
                'startDate' => Carbon::now()->add(1, 'week'),
                'endDate' => Carbon::now()->add(1, 'week'),
                
            
             ]);
        } catch (\Google_Service_Exception $e) {
            $ev = Event::find('eventid'.$newOrder->id);
            $ev->status = "confirmed";
            $ev->startDate = Carbon::now()->add(1, 'week');
            $ev->endDate = Carbon::now()->add(1, 'week');
            $ev->save();
        
        }
        
        
        

        return redirect()->route('orders.index');


        
    }

    public function uploadFile(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        $date = $order->term;

        

        if($request->hasFile('invoice')){
            $path = 'public/invoices';
            $invoice = $request->file('invoice');
            $invoice_name = $invoice->getClientOriginalName();
            $fullPath = $request->file('invoice')->storeAs($path, $invoice_name);
            
            $input['invoice'] = $invoice_name;
        } else {
            return back();
        }
        
        
        DB::update(DB::raw('UPDATE orders SET orders.invoice = "'.$invoice_name.'", orders.term = "'.$order->term.'"  WHERE orders.id = '.$orderId.''));


        return redirect()->route('orders.index');
    }

    

    
}
