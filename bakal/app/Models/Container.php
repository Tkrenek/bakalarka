<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Package_item;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'bulk',
        'on_store',
        'prize',
        'code'
    ];

    public function packageItem()
    {
        return $this->hasMany(Package_item::class);
    }
}

