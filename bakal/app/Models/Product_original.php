<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Producer;
use App\Models\Item;
use App\Models\Mixing_product;

class Product_original extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'on_store',
        'code',
        'prize',
        'producer',
        'branch',
        'producer_id'

    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    public function mixingProduct()
    {
        return $this->hasMany(Mixing_product::class);
    }

    public function addOnStore($id, Request $request)
    {
        $product = Product_original::find($id);


        $product->on_store = $product->on_store + $request->ammount;

        $product->save();

        return back();
        
    }

}