<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email',60)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_pic',100)->default('user/avatar.png');
            $table->string('cover_picture',100)->default('user/cover.png');
            $table->string('country_code',5)->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->tinyInteger('profile_setup')->default(1);
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('gender')->default(1)->comment('1 for male, 2 for female');
            $table->float('version')->nullable();
            $table->date('dob')->nullable();
            $table->string('address',100)->nullable();
            $table->string('latitude',20)->nullable();
            $table->string('longitude',20)->nullable();
            $table->string('social_provider_uid',30)->nullable();
            $table->tinyInteger('social_provider_type')->comment('1 for fb, 2 for G')->nullable();
            $table->tinyInteger('device_type')->comment('1 for Android, 2 for IOS, 3 for Web')->default('0');
            $table->string('user_type',1)->comment('1 for Admin, 2 for Customer')->default('0');
            $table->string('otp',6)->default('123456')->nullable();
            $table->tinyInteger('verify_otp')->default(0);
            $table->tinyInteger('notif_status')->default(1)->comment('1 on, 0 off');
            $table->char('token',191)->nullable();
            $table->char('device_id',191)->nullable();
            $table->rememberToken();//do length 191 manually
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
        Schema::dropIfExists('users');
    }
}
