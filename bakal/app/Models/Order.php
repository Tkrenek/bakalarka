<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Item;
use App\Models\Subscriber;

use App\Models\OrderWork;

class Order extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'state',
        'term',
        'subscriber_id',
        'invoice',
   
    ];


    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function orderWork()
    {
        return $this->hasMany(OrderWork::class);
    }


}
