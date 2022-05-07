<?php
/**
 * Nazev souboru: Department.php
 * Model pro oddeleni
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    /**
     * Metoda vraci zamestnance, kteri patri do oddeleni
     * @return App\Models\Employee
     */
    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
