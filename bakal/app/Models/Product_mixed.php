<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Mixing_product;

class Product_mixed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'branch',
        'prize',
        'on_store'

    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function mixingProduct()
    {
        return $this->hasMany(Mixing_product::class);
    }


}
