<?php
/**
 * Migracni soubor pro tabulku michanych produktu
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMixedsTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mixeds', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('branch');
            $table->integer('prize');
            $table->integer('on_store')->default(0);
            $table->timestamps();
        });

        DB::table('product_mixeds')->insert(
            array(
                'name' => 'default',
                'code' => 'M-default',
                'branch' => 1,
                'prize' => 1,
                'on_store' => 1
            )
        );
    }

   
    public function down()
    {
        Schema::dropIfExists('product_mixeds');
    }
}
