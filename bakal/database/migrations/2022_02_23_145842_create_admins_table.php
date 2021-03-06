<?php
/**
 * Migracni soubor pro tabulku admina
 * @author Tomas Krenek(xkrene15)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Spusteni migrace.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->dateTime('birth_date');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamps();
            $table->rememberToken();
        });

        DB::table('admins')->insert(
            array(
                'name' => 'Tomáš',
                'surname' => 'Křenek',
                'phone' => '156458754',
                'email' => 'admin@admin.cz',
                'password' => Hash::make('admin'),

                'birth_date' => '1999-03-03',
            )
        );
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
