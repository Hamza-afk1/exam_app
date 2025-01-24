<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('duree');
            $table->foreignId('formateur_id')->constrained('formateurs');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cours');
    }
};