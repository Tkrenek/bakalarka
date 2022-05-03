<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Container;

class ContainerController extends Controller
{
    /**
     * Vraci pohled se vsemi nadobamis
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('containers.create'); // vrati pohled
    }

    /**
     * Vlozeni zaznamu s nadoubou do databazeS
     * 
     * @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // Overeni udaju z formulare
        $this->validate($request, [
            'type' => 'required',
            'bulk' =>'required|numeric',
            'on_store' => 'required|numeric',
            'prize' => 'required|numeric',
            'code' => 'required'
        ]);

        // Vytvoreni nove nadoby
        Container::create([
            'type' => $request->type,
            'bulk' => $request->bulk,
            'on_store' => $request->on_store,
            'prize' => $request->prize,
            'code' => $request->code,

        ]);

        return back(); // navrat zpet
    
    }

    /**
     * Vraci pohled se vsemi nadobami
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $containers = Container::get(); // ulozi vsechny nadoby do promenne
         
        // vraci pohle s nadobami
        return view('containers.index', [
            'containers' => $containers,
        ]);
    }

    /**
     * Vraci pohled s formularem pro
     * upravu nadoby
     * 
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $container = Container::where('id', $id)->first(); // Vyhleda nadobu podle ID
        
        // vraci pohled s nadobami
        return view('containers.update', [
            'container' => $container
        ]);
    }


    /**
     * Aktualizuje v databazi parametry nadoby
     * 
     * @return \Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        // overeni udaju z formulare
        $this->validate($request, [
            'type' => 'required',
            'bulk' =>'required',
            'prize' => 'required',
            'on_store' => 'required',
            'code' => 'required'
            
        ]);
 
        $container = Container::find($id); // vyhledani nadoby podle ID

        // zmena udaju o nadobe
        $container->type = $request->type;
        $container->bulk = $request->bulk;
        $container->prize = $request->prize;
        $container->on_store = $request->on_store;
        $container->code = $request->code;
    
        $container->save(); // ulozeni udaju

        $containers = Container::get(); // ulozeni vsech nadob do promenne

        // vraci pohled s nadobami
        return redirect()->route('containers.index');
    }

    /**
     * Odstani nadobu z databaze
     */
    public function destroy($id)
    {

        $container = Container::find($id); // vyhledani nadoby podle ID
        $container->delete(); // smazani nadoby

        return back(); // navrat zpet
    }

    /**
     * Metoda pro naskladneni nadob 
     * 
     * @param Illuminate\Http\Request
     */
    public function addOnStore($id, Request $request)
    {
        $container = Container::find($id);  // vyhledani nadoby podle ID

        // overeni, zda bylo zadano mnozstvi
        $this->validate($request, [
            'ammount' => 'required|numeric',
        ]);

        $container->on_store = $container->on_store + $request->ammount; // doplneni zasob na sklade

        $container->save(); // ulozeni

        return back(); // navrat zpet
        
    }
}
