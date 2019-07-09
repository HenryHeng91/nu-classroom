<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_title', 150);
            $table->text('description');
            $table->bigInteger('instructor_id');
            $table->string('url')->unique();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('access');
            $table->bigInteger('status');
            $table->integer('members_count')->default(0);
            $table->bigInteger('organization_id')->nullable();
            $table->dateTime('start_date')->default(now());
            $table->dateTime('end_date')->nullable();
            $table->timestamp('class_start_time')->nullable();
            $table->timestamp('class_end_time')->nullable();
            $table->string('class_days');
            $table->string('color', 6);
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
        Schema::dropIfExists('virtual_classes');
    }
}
