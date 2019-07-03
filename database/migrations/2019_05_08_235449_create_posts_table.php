<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('detail');
            $table->bigInteger('user_id');
            $table->bigInteger('class_id');
            $table->bigInteger('access');
            $table->bigInteger('post_type');
            $table->bigInteger('classwork_id');
            $table->integer('status');
            $table->integer('view_counts');
            $table->integer('like_count');
            $table->bigInteger('file_id');
            $table->uuid('guid');
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
        Schema::dropIfExists('posts');
    }
}
