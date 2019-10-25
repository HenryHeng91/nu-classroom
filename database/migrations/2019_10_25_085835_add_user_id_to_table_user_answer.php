
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToTableUserAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('answer_id')->nullable()->change();
            $table->text ('answers_detail')->nullable()->change();
            $table->boolean('isCorrect')->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->bigInteger('answer_id')->change();
            $table->text ('answers_detail')->change();
            $table->boolean('isCorrect')->change();

        });
    }
}
