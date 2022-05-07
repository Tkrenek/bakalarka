<?php
/**
 * Nazev souboru: OrderWork.php
 * Model pro praci na objednavce
 * @author Tomas Krenek(xkrene15)
 */

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
        'work_type',
        'date',
        'time'
    ];


    /**
     * Metoda vraci objednavku, na ktere je provedena tato prace
     * @return App\Models\Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Metoda vraci zamestnance, kteri provedli praci na teto objednavce
     * @return App\Models\Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
