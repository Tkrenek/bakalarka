<?php
/**
 * Migracni soubor pro tabulku dodavatele
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducersTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('town');
            $table->timestamps();

           
        });
        DB::table('producers')->insert(
            array(
                'name' => 'default',
                'phone' => '999999999',
                'email' => 'email@email.cz',
                'address' => 'default',
                'town' => 'default',
            )
        );
    }

  
    public function down()
    {
        Schema::dropIfExists('producers');
    }
}
