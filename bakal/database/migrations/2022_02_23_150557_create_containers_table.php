<?php
/**
 * Migracni soubor pro tabulku nadob
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique('containers');
            $table->string('type');
            $table->integer('bulk');
            $table->integer('prize');
            $table->integer('on_store');
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
