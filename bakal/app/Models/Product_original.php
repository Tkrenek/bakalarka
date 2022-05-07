<?php
/**
 * Nazev souboru: Product_original.php
 * Model pro originalni produkt
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Producer;
use App\Models\Item;
use App\Models\Mixing_product;

class Product_original extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'on_store',
        'code',
        'prize',
        'producer',
        'branch',
        'producer_id'

    ];

    /**
     * Metoda vraci polozku, do ktere patri tento produkt
     * @return App\Models\Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Metoda vraci dodavatele, ktery dodava tento produkt
     * @return App\Models\Producer
     */
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }

    /**
     * Metoda vraci recept, ve kterem je pouzit tento produkt
     * @return App\Models\Mixing_product
     */
    public function mixingProduct()
    {
        return $this->hasMany(Mixing_product::class);
    }

    /**
     * Metoda pro naskladneni
     * @return App\Models\Order
     */
    public function addOnStore($id, Request $request)
    {
        $product = Product_original::find($id);


        $product->on_store = $product->on_store + $request->ammount;

        $product->save();

        return back();
        
    }

}