<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Department;
use App\Models\OrderWork;

class Employee extends Authenticatable
{


    use HasFactory;
    use Notifiable;

    protected $guard = 'employee';

    protected $fillable = [
        'name',
        'surname',
        'password',
        'email',
        'phone',
        'login',
        'department_id',
        'function',
        'birth_date',
        'year',
        'month',
        'date'
        

    ];

    

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function orderWork()
    {
        return $this->hasMany(OrderWork::class);
    }


}
