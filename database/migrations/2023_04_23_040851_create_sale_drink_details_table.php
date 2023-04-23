<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDrinkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_drink_details', function (Blueprint $table) {
            $table->id();
            $table->Integer('order_id');
            $table->unsignedBigInteger('d_id');
            $table->integer('qty');
            $table->float('price');
            $table->float('total');
            $table->timestamps();
            $table->foreign('d_id')
            ->references('id')
            ->on('drinks')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_drink_details');
    }
}
