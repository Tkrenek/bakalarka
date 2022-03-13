<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product_mixed;
use App\Models\Product_original;

class Mixing_product extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_mixed_id',
        'product_original_id'
    ];

    public function productOriginal()
    {
        return $this->belongsTo(Product_original::class);
    }

    public function productMixed()
    {
        return $this->belongsTo(Product_mixed::class);
    }
}
