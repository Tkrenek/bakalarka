<?php
/**
 * Nazev souboru: Employee.php
 * Model pro zamestnance
 * @author Tomas Krenek(xkrene15)
 */

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
        'department_id',
        'function',
        'birth_date',
        'year',
        'month',
        'date'
        

    ];

    
    /**
     * Metoda vraci oddeleni, na kterem zakaznik pracuje
     * @return App\Models\Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Metoda vraci prace, ktere provedl zamestnanec
     * @return App\Models\OrderWork
     */
    public function orderWork()
    {
        return $this->hasMany(OrderWork::class);
    }

    
}
