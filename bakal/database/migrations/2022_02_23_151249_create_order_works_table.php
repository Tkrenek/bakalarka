<?php
/**
 * Migracni soubor pro tabulku praci na objednavce
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWorksTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('work_type');
            $table->timestamp('date');
            $table->string('time');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_works');
    }
}
