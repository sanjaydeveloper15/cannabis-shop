<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrainTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strain_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',40)->unique()->unique();
            $table->string('icon',100)->nullable()->unique()->unique();
            $table->tinyInteger('status')->default(1)->comment('1 for active, 0 for not');
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
        Schema::dropIfExists('strain_types');
    }
}
