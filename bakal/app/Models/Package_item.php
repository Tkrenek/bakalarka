<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Item;
use App\Models\Container;


class Package_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'container_id',
        'count',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
