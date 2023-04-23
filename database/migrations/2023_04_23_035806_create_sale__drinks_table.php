<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale__drinks', function (Blueprint $table) {
            $table->biginteger('order_id')->autoIncrement();
            $table->unsignedBigInteger('emp_id');
            $table->string('receive_name',50);
            $table->float('tatol');
            $table->integer('order_status')->default(1);
            $table->timestamps();
            $table->foreign('emp_id')
            ->references('id')
            ->on('employees')
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
        Schema::dropIfExists('sale__drinks');
    }
}
