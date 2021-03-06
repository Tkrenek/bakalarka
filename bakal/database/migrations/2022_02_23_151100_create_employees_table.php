<?php
/**
 * Migracni soubor pro tabulku zamestnancu
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone');
            $table->dateTime('birth_date');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('function');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
