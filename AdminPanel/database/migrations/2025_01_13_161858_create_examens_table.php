<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cou_id')->constrained('cours');
            $table->foreignId('groupe_id')->constrained('groupes');
            $table->string('titre');
            $table->text('description');
            $table->integer('duree');
            $table->integer('nombre_questions');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('examens');
    }
};