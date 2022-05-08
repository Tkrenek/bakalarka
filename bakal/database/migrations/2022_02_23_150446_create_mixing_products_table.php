<?php
/**
 * Migracni soubor pro tabulku michani produktu
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixingProductsTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixing_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_mixed_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_original_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('mixing_products');
    }
}
