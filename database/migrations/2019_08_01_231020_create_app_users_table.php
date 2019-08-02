<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('password');
            $table->string('profile_pic')->default('avatar.png');
            $table->string('accountkit_id')->unique();
            $table->longText('access_token');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date');
            $table->string('email')->nullable()->unique();
            $table->string('phone', 40)->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('self_description')->nullable();
            $table->string('education_level')->nullable();
            $table->integer('status')->default(0);
            $table->integer('role')->default(1);
            $table->uuid('guid')->default(uniqid())->unique();
            $table->timestamps();

            $table->unique(['username', 'password']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
