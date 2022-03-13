<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;

use App\Models\Product_original;

use App\Models\Product_mixed;
use App\Models\Package_item;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
        'amount',
        'product_mixed_id',
        'product_original_id',
        'is_mixed',
        'order_id'

    ];


    public function productOriginal()
    {
        return $this->belongsTo(Product_original::class);
    }

    public function productMixed()
    {
        return $this->belongsTo(Product_mixed::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function packageItem()
    {
        return $this->hasMany(Package_item::class);
    }



}
