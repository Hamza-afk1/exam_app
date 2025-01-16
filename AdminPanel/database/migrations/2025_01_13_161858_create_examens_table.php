<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamensTable extends Migration
{
    public function up()
    {
        Schema::create('examens', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->string('nom'); // Nom de l'examen
            $table->unsignedBigInteger('groupe_id'); // Clé étrangère vers groupes
            $table->integer('questions'); // Nombre de questions
            $table->string('type_question'); // Type des questions
            $table->timestamps(); // Champs created_at et updated_at

            // Définir la relation étrangère
            $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('examens');
    }
}
