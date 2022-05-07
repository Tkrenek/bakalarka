<?php
/**
 * Nazev souboru: Producer.php
 * Model pro dodavatele
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product_Original;

class Producer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'town'
    ];

    /**
     * Metoda vraci produkty, ktere jsou dodavany dodavatelem
     * @return App\Models\Product_Original
     */
    public function productOriginal()
    {
        return $this->hasMany(Product_Original::class);
    }
}
