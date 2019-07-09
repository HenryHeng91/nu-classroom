<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('detail');
            $table->bigInteger('user_id');
            $table->bigInteger('class_id');
            $table->datetime('appoint_from');
            $table->datetime('appoint_to');
            $table->bigInteger('classwork_id');
            $table->bigInteger('classwork_type');
            $table->integer('status');
            $table->integer('view_counts');
            $table->integer('like_count');
            $table->bigInteger('file_id');
            $table->uuid('guid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_classes');
    }
}
