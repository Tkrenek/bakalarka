<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscriber;


class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'email',
        'birth_date',
        'subscriber_id'
    ];



    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
