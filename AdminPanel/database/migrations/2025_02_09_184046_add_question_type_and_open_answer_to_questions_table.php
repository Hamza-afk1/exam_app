<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->enum('question_type', ['qcm', 'open'])->default('qcm'); // Type de question
            $table->text('open_answer')->nullable(); // Réponse attendue pour les questions ouvertes
        });
    }
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('question_type');
            $table->dropColumn('open_answer');
        });
    }
};
