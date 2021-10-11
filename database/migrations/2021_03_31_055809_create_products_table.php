<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',100)->index();
            $table->longText('description')->nullable();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('device_type_id')->unsigned()->index()->nullable();
            $table->foreign('device_type_id')->references('id')->on('device_types')->onDelete('cascade');
            $table->bigInteger('brand_id')->unsigned()->index()->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->bigInteger('strain_type_id')->unsigned()->index()->nullable();
            $table->foreign('strain_type_id')->references('id')->on('strain_types')->onDelete('cascade');
            $table->char('potency',16)->nullable()->comment('biological activity of a given product');
            $table->char('sku_code',100)->nullable()->unique()->comment('stock-keeping unit (SKU) is a scannable bar code');
            $table->char('product_id_show',24)->nullable()->unique()->index();
            $table->bigInteger('corresponding_product_id')->unsigned()->index()->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 for active, 0 for not');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
