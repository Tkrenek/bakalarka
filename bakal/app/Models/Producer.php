<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product_Original;

class Producer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'town'
    ];

    public function productOriginal()
    {
        return $this->hasMany(Product_Original::class);
    }
}
