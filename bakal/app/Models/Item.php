<?php
/**
 * Nazev souboru: Item.php
 * Model pro polozku obednavky
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;

use App\Models\Product_original;

use App\Models\Product_mixed;
use App\Models\Package_item;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
        'amount',
        'product_mixed_id',
        'product_original_id',
        'is_mixed',
        'order_id'

    ];


    /**
     * Metoda vraci originalni produkt, ktery je soucasti tohoto produktu
     * @return App\Models\Product_original
     */
    public function productOriginal()
    {
        return $this->belongsTo(Product_original::class);
    }

    /**
     * Metoda vraci michany produkt, ktery je soucasti tohoto produktu
     * @return App\Models\Product_mixed
     */
    public function productMixed()
    {
        return $this->belongsTo(Product_mixed::class);
    }

    /**
     * Metoda vraci objednavku, do ktere patri tato polozka
     * @return App\Models\Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    /**
     * Metoda vraci zabaleni, kterym je zabalena tato polozka
     * @return App\Models\Package_item
     */
    public function packageItem()
    {
        return $this->hasMany(Package_item::class);
    }



}
