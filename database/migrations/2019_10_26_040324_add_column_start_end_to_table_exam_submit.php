<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStartEndToTableExamSubmit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_submits', function (Blueprint $table) {
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
        });

        Schema::table('exams', function (Blueprint $table){
            $table->integer('duration');
            $table->enum('show_result_at', ['IMMEDIATE', 'EXAM_FINISH'])->nullable();  // if null mean IMMEDIATE
            $table->boolean('auto_grade')->default(0);
            $table->dateTime('exam_notify')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_submits', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });

        Schema::table('exams', function (Blueprint $table){
            $table->dropColumn('duration');
            $table->dropColumn('show_result_at');
            $table->dropColumn('auto_grade');
            $table->dropColumn('exam_notify');
        });
    }
}
