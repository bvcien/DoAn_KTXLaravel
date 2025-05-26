<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCccdSexCompetenceToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cccd')->after('msv');
            $table->string('sex')->after('cccd');
            $table->integer('competence')->after('sex');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cccd', 'sex', 'competence']);
        });
    }
}
