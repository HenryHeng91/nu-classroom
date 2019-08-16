<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnClassStartTimeAndClassEndTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtual_classes', function (Blueprint $table) {
            $table->time('class_start_time')->nullable()->change();
            $table->time('class_end_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtual_classes', function (Blueprint $table) {
            $table->timestamp('class_start_time')->nullable()->change();
            $table->timestamp('class_end_time')->nullable()->change();
        });
    }
}
