<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToStagiairesTable extends Migration
{
    public function up()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->string('prenom')->after('name'); // Add 'prenom' after 'name'
            $table->string('groupe')->after('prenom'); // Add 'groupe' after 'prenom'
            $table->string('password')->after('email'); // Add 'password' after 'email'
        });
    }

    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'groupe', 'password']); // Drop the columns if rolling back
        });
    }
}