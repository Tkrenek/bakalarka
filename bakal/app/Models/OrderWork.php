<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Employee;

class OrderWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'employee_id',
        'work_type'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
