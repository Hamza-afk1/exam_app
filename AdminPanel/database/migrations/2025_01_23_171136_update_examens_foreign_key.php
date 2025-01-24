<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('examens', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte
            $table->dropForeign(['groupe_id']);
            
            // Ajouter la nouvelle contrainte avec onDelete('set null')
            $table->foreign('groupe_id')
                  ->references('id')
                  ->on('groupes')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->dropForeign(['groupe_id']);
            
            // Remettre la contrainte originale
            $table->foreign('groupe_id')
                  ->references('id')
                  ->on('groupes');
        });
    }
};