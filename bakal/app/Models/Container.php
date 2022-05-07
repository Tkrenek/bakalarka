<?php
/**
 * Nazev souboru: Container.php
 * Model pro nadobu
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Package_item;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'bulk',
        'on_store',
        'prize',
        'code'
    ];

    /**
     * Metoda vraci polozky, ktere jsou zabaleny do konkretni nadoby
     * @return App\Models\Package_item
     */
    public function packageItem()
    {
        return $this->hasMany(Package_item::class);
    }
}

