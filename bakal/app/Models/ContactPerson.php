<?php
/**
 * Nazev souboru: ContactPerson.php
 * Model pro kontaktni osobu
 * @author Tomas Krenek(xkrene15)
 */

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


    /**
     * Metoda vraci zakaznika, ke kteremu patri kontaktni osoba
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
