<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupesTable extends Migration
{
    /**
     * Exécutez la migration.
     */
    public function up()
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Utilisez 'nom' si c'est votre convention
            $table->timestamps();
        });
    }

    /**
     * Annulez la migration.
     */
    public function down()
    {
        Schema::dropIfExists('groupes');
    }
}
