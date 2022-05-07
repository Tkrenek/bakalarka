<?php
/**
 * Nazev souboru: Package_Item.php
 * Model pro baleni objednavky
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Item;
use App\Models\Container;


class Package_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'container_id',
        'count',
    ];

    /**
     * Metoda vraci polozky, ktere jsou zabaleny
     * @return App\Models\Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Metoda vraci nadoby, do kterych je polozka zabalena
     * @return App\Models\Container
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
