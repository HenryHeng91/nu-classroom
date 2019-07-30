<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_backgrounds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('file_id');
            $table->bigInteger('category_id');
            $table->uuid('guid');
            $table->timestamps();
        });

        Schema::table('virtual_classes', function (Blueprint $table){
            $table->bigInteger('classBackgrounds_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_backgrounds');
        Schema::table('virtual_classes', function (Blueprint $table) {
            $table->dropColumn('classBackgrounds_id');
        });

    }
}
