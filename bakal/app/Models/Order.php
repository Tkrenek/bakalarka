<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Item;
use App\Models\Customer;

use App\Models\OrderWork;
Use DB;

class Order extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'state',
        'term',
        'customer_id',
        'invoice',
   
    ];


    public static $frequented = array();

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderWork()
    {
        return $this->hasMany(OrderWork::class);
    }

   
}
