<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;


class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'email',
        'birth_date',
        'customer_id'
    ];



    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
