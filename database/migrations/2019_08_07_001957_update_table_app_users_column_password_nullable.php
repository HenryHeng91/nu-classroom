<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableAppUsersColumnPasswordNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->string('birth_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *e
     * @return void
     */
    public function down()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->string('password')->change();
            $table->string('birth_date')->change();
        });
    }
}
