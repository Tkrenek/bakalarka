<?php
/**
 * Nazev souboru: Product_mixed.php
 * Model pro michane produkty
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Mixing_product;

class Product_mixed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'branch',
        'prize',
        'on_store'

    ];

    /**
     * Metoda vraci polozku, ke ktere patri tento produkt
     * @return App\Models\Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Metoda vraci recept tohoto produktu
     * @return App\Models\Mixing_product
     */
    public function mixingProduct()
    {
        return $this->hasMany(Mixing_product::class);
    }


}
