<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->char('message');
            $table->bigInteger('user_id')->unsigned()->index()->comment('to user id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('for_all_user')->default(0);
            $table->integer('obj_id');
            $table->tinyInteger('obj_type')->comment('1 order, 2 user');
            $table->tinyInteger('viewed')->default(0);
            $table->tinyInteger('badge_viewed')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
