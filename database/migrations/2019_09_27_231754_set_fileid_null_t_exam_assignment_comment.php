<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFileidNullTExamAssignmentComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->bigInteger('file_id')->nullable()->change();
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->bigInteger('file_id')->nullable()->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger('file_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->bigInteger('file_id')->change();
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->bigInteger('file_id')->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger('file_id')->change();
        });
    }
}
