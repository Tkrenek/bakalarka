<?php
/**
 * Nazev souboru: Mixing_Product.php
 * Model pro michani produktu
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product_mixed;
use App\Models\Product_original;

class Mixing_product extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_mixed_id',
        'product_original_id'
    ];

    /**
     * Metoda vraci originalni produkt, ktery je soucasti receptu michaneho produktu
     * @return App\Models\Product_original
     */
    public function productOriginal()
    {
        return $this->belongsTo(Product_original::class);
    }

    /**
     * Metoda vraci michany produkt, pro ktery je tento recept urcen
     * @return App\Models\Product_mixed
     */
    public function productMixed()
    {
        return $this->belongsTo(Product_mixed::class);
    }
}
