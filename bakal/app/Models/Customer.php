<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\ContactPerson;
use App\Models\Order;

class Customer extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'town',
        'address',
        'login',
        'password',
        'url'
    ];

    public function contact()
    {
        return $this->hasMany(ContactPerson::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
