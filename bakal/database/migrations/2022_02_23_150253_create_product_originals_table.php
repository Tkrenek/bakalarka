<?php
/**
 * Migracni soubor pro tabulku originalnich produktu
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOriginalsTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_originals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('branch');
            $table->string('on_store');
            $table->integer('prize');
            $table->foreignId('producer_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            
        });
        DB::table('product_originals')->insert(
            array(
                'name' => 'default_original',
                'branch' => 'default',
                'code' => 'O-default',
                'prize' => 1,
                'on_store' => 1,
                'producer_id' => 1,
            )
        );
    }

    
    public function down()
    {
        Schema::dropIfExists('product_originals');
    }
}
