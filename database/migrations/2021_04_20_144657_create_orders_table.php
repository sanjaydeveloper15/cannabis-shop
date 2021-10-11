<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('order_id_show',24)->index()->unique();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('invoice_no',12)->unique()->index();
            $table->decimal('price',8,2)->comment('payable amount');
            $table->decimal('tax',8,2)->default(0);
            $table->decimal('discount',8,2)->default(0);
            $table->decimal('total_price',8,2)->comment('total payable amount');
            $table->tinyInteger('tracking_status')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0 new, 1 in process, 2 upcoming, 3 completed, 4 cancelled, 5 rejected');
            $table->tinyInteger('delivery_type')->default(1)->comment('1 delivery at address, 2 self pickup');
            $table->string('cancel_reason',100)->nullable();
            $table->tinyInteger('cancel_by')->default(0)->comment('1 user');
            $table->char('product_name_str',191)->nullable();
            $table->integer('total_items')->default(1);
            $table->timestamp('in_process_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
