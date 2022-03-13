<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Container;

class ContainerController extends Controller
{
    public function create()
    {
        return view('containers.create');
    }

    public function store(Request $request)
    {
        

        $this->validate($request, [
            'type' => 'required',
            'bulk' =>'required|numeric',
            'on_store' => 'required|numeric',
            'prize' => 'required|numeric',
            'code' => 'required'
            
        ]);

        Container::create([
            'type' => $request->type,
            'bulk' => $request->bulk,
            'on_store' => $request->on_store,
            'prize' => $request->prize,
            'code' => $request->code,

        ]);

        return back();
    
    }

    public function index()
    {
        $containers = Container::get();
        return view('containers.index', [
            'containers' => $containers,
        ]);
    }

    public function edit($id)
    {
        $container = Container::where('id', $id)->first();
        return view('containers.update', [
            'container' => $container
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'bulk' =>'required',
            'prize' => 'required',
            'on_store' => 'required',
            'code' => 'required'
            
        ]);
 
        $container = Container::find($id);

        
        $container->type = $request->type;
        $container->bulk = $request->bulk;
        $container->prize = $request->prize;
        $container->on_store = $request->on_store;
        $container->code = $request->code;
    
 

        $container->save();

        $containers = Container::get();
        return view('containers.index', [
            'containers' => $containers
        ]);
    }

    public function destroy($id)
    {
        $container = Container::find($id);
        $container->delete();

        return back();
    }

    public function addOnStore($id, Request $request)
    {
        $container = Container::find($id);


        $this->validate($request, [
            'ammount' => 'required|numeric',
            
            
        ]);

        $container->on_store = $container->on_store + $request->ammount;

        $container->save();

        return back();
        
    }
}
