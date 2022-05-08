<?php
/**
 * Nazev souboru: OrderWorkController.php
 * Controller pro odvedenou praci na objednavkach
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderWork;
use App\Models\Employee;

class OrderWorkController extends Controller
{
    /**
     * Zobrazeni pohledu s formularem pro oznaceni prace
     * @return \Illuminate\View\View
     */
    public function create($orderId)
    {
        $order = Order::find($orderId); // vyhledani objednavky podle ID

        // vraceni pohledu
        return view('orderwork.create', [
            'order' => $order
        ]);
    }

    /**
     * Vraceni pohledu s formularem pro oznaceni prace pro admina
     * @return \Illuminate\View\View
     */
    public function  createAsAdmin($emplId)
    {
        $employee = Employee::find($emplId); // vyhledani zamestnance podle ID

        // vraceni pohledu se zamestnanci
        return view('orderwork.create', [
            'employee' => $employee
        ]);
    }
   
    /**
     * Metoda pro ulozeni prace na objednavce do databaze
     *@param Illuminate\Http\Request
     */
    public function store(Request $request, $orderId)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'type' => 'required',
            'time' => 'required|numeric|min:1',
            'date' => 'required|date',
            'order' => 'required|exists:orders,id|numeric'
            
        ]);
        

        // Vytvoreni prace na objednavce v databazi
        OrderWork::create([
            'order_id' => $orderId,
            'employee_id' => auth('employee')->user()->id,
            'work_type' => $request->type,
            'time' => $request->time,
            'date' => $request->date,

        ]);

        return redirect()->route('orders.index'); // presmerovani
    }

    /**
     * Ulozeni prace na objednavce jako admin
     * @param Illuminate\Http\Request
     */
    public function storeAsAdmin(Request $request, $emplId)
    {
        // overeni dat z formulare
        $this->validate($request, [
            'order' => 'required|exists:orders,id|numeric',
            'type' => 'required',
            'time' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);
        
        $employee = Employee::find($emplId); // vyhledani zamestnance podle ID

        // vytoverni prace na obednavce
        OrderWork::create([
            'order_id' => $request->order,
            'employee_id' => $employee->id,
            'work_type' => $request->type,
            'time' => $request->time,
            'date' => $request->date,

        ]);


        return redirect()->route('orderWork.index'); // presmerovani
    }

    /**
     * Zobrazeni praci na objednavce
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        if(auth('employee')->user()){ // pokd je prilasen zamestnaec
            return view('orderwork.index', [
                'orderworks' => auth('employee')->user()->orderWork // vrati se prace ktere odvedl prihlaseny zamestnanec
            ]);
        }
        // pokud je prihlasen admin
        $orderworks = OrderWork::get(); // zikani vsech praci na objednavkach

        // vraceni pohledu se vsemi pracemi na objednavkach
        return view('orderwork.index', [
            'orderworks' => $orderworks
        ]);
    }

    /**
     * Metoda pro odstraneni zaznamu o provedene praci z databaze
     */
    public function destroy($id)
    {
        $orderWokrk = OrderWork::find($id); // vyhledani konkretni prace
        $orderWokrk->delete(); // smazani

        return back();
    }
}
