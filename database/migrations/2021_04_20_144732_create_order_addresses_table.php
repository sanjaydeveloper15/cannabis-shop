<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('type')->default(1)->comment('1 home, 2 office, 3 other');
            $table->integer('country_id');
            $table->char('country_name',60)->nullable();
            $table->integer('city_id');
            $table->char('city_name',60)->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->char('street_name')->nullable();
            $table->char('apartment_name')->nullable();
            $table->char('sector')->nullable();
            $table->char('residential_name')->nullable();
            $table->char('country_code',10);
            $table->char('mobile_number',16);
            $table->integer('area_code')->nullable();
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
        Schema::dropIfExists('order_addresses');
    }
}
