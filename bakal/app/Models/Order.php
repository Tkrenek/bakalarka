<?php
/**
 * Nazev souboru: Order.php
 * Model pro objednavku
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Item;
use App\Models\Customer;

use App\Models\OrderWork;
Use DB;

class Order extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'state',
        'term',
        'customer_id',
        'invoice',
    ];

  

    public static $frequented = array();

    
    /**
     * Metoda polozky, ktere jsou soucasti teto objednavky
     * @return App\Models\Item
     */
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Metoda vraci zakaznnika, kteremu tato objednavka patri
     * @return App\Models\Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Metoda vraci prace na teto objednavce
     * @return App\Models\OrderWork
     */
    public function orderWork()
    {
        return $this->hasMany(OrderWork::class);
    }

   
}
