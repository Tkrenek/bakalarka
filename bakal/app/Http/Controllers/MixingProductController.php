<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product_original;
use App\Models\Product_mixed;
use App\Models\Mixing_product;

class MixingProductController extends Controller
{
    public function create()
    {
        $mixeds = Product_mixed::get();
        $originals = Product_original::get();

        return view('mixingProduct.create', [
            'mixeds' => $mixeds,
            'originals' => $originals
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'original' => 'required',
            'mixed' =>'required',
        ]);

        $original = Product_original::where('code', $request->original)->first();
        $mixed = Product_mixed::where('code', $request->mixed)->first();


        Mixing_product::create([
            'product_original_id' => $original->id,
            'product_mixed_id' => $mixed->id,
            
        ]);

        return back();
    }

    public function index()
    {
        $mixeds = Product_mixed::get();
        return view('mixingProduct.index', [
            'mixeds' => $mixeds
        ]);
    }
}
