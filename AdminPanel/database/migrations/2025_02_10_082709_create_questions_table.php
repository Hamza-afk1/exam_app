<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['qcm', 'open']);
            $table->text('open_answer')->nullable(); // Réponse attendue pour question ouverte
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
