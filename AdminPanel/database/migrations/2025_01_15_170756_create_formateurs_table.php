<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFormateursTable extends Migration
{
    public function up()
    {
        Schema::table('formateurs', function (Blueprint $table) {
            $table->string('prenom')->after('name'); // Add 'prenom' after 'name'
            $table->string('password')->after('email'); // Add 'password' after 'email'
        });
    }

    public function down()
    {
        Schema::table('formateurs', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'password']); // Drop the columns if rolling back
        });
    }
}
