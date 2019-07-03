<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyticEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytic_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('device_id', 250);
            $table->string('device_brandname', 250);
            $table->string('device_modelname', 250);
            $table->string('device_os', 100);
            $table->bigInteger('event_id');
            $table->datetime('event_start');
            $table->datetime('event_end');
            $table->double('event_duration_in_mn');
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
        Schema::dropIfExists('analytic_events');
    }
}
